<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        $plainPassword = $request->password;
        $password = bcrypt($request->password);
        $request->merge(['password' => $password]);

        // Create the client account
        $created = Client::create($request->all());
        $request->merge(['password' => $plainPassword]);

        // Login now
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        // Get the client
        $client = JWTAuth::user();

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'client' => $client
        ]);
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'Client logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the client cannot be logged out'
            ], 500);
        }
    }

    public function getCurrentClient(Request $request)
    {
        $client = JWTAuth::parseToken()->authenticate();

        return $client;
    }

    public function update(Request $request)
    {
        $client = $this->getCurrentClient($request);
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client is not found'
            ]);
        }

        $data = $request->except(['token']); // Extract all request data except 'token'

        $client->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Information has been updated successfully!',
            'client' => $client
        ]);
    }
}
