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

class ForgotPasswordController extends Controller
{
    // Method to send reset link
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = Password::broker('clients')->sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        // Fetch the client based on the email
        $client = Client::where('email', $request->email)->first();

        // If client is found, send the email
        if ($client) {
            $token = Password::broker('clients')->createToken($client); // Create the token

            // Generate the password reset URL
            $url = URL::temporarySignedRoute(
                'password.reset', // Named route for password reset
                now()->addMinutes(60), // Expiration time
                ['email' => $client->email, 'token' => $token]
            );

            // Pass the client, token, and URL to the ResetPasswordMail
            Mail::to($client->email)->send(new ResetPasswordMail($client, $token, $url));
        }

        return response()->json(['message' => trans($status)], 200);
    }

    return response()->json(['message' => trans($status)], 400);
}

    // Unified reset method
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

        $status = Password::broker('clients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($client, $password) {
                $client->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => trans($status)], 200);
        }

        return response()->json(['message' => trans($status)], 400);
    }
}
