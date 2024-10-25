<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail; // Import your mail class
use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log; // Import Log facade
use App\Mail\PasswordChangedNotification;

class ForgotPasswordController extends Controller
{
    // Method to send reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Fetch the client based on the email
        $client = Client::where('email', $request->email)->first();

        // If client is found, generate the token and send the email
        if ($client) {
            // Generate the token first and use it both in the email and response
            $token = Password::broker('client')->createToken($client);

            // Generate the password reset URL
            $url = URL::temporarySignedRoute(
                'password.reset',
                now()->addMinutes(60),
                ['email' => $client->email, 'token' => $token]
            );

            // Pass the client, token, and URL to the ResetPasswordMail
            Mail::to($client->email)->send(new ResetPasswordMail($client, $token, $url));

            return response()->json([
                'message' => 'We have emailed your password reset link!',
                'token' => $token, // Include the token in the response
            ], 200);
        }

        return response()->json(['message' => 'We couldn\'t find a user with that email address.'], 400);
    }

    // Method to show the reset password form
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    public function reset(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:client,email',
        'token' => 'required',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 403);
    }

    // Log the reset request for debugging
    Log::info('Password reset request', [
        'email' => $request->email,
        'token' => $request->token,
    ]);

    // Attempt to reset the password
    $status = Password::broker('client')->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($client, $password) {
            $client->forceFill([
                'password' => bcrypt($password),
            ])->save();

            // Send notification email after successful password reset
            Mail::to($client->email)->send(new PasswordChangedNotification($client));
        }
    );

    // Log the status of the reset operation
    Log::info('Reset status', ['status' => $status]);

    // if ($status === Password::PASSWORD_RESET) {
    //     // Instead of returning JSON, return a view for success
    //     return view('auth.passwords.reset_success');
    // }

    //   // Handle invalid token
    // if ($status === Password::INVALID_TOKEN) {
    //     return view('auth.passwords.invalid_token');
    // }
    if ($status === Password::PASSWORD_RESET) {
        // Instead of returning JSON, return a view for success
        return view('auth.passwords.reset_success');
    } else {
        // Handle invalid token case
        return view('auth.passwords.invalid_token'); // Return the invalid token view
    }

    return response()->json(['message' => trans($status)], 400);
}






}
