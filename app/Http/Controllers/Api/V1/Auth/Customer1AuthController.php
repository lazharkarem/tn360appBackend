<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Validator;

class Customer1AuthController extends Controller
{


//     public function login(Request $request)
// {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $client = Auth::user();
//         $token = $client->createToken('360TNAuth')->accessToken;

//         return response()->json([
//             'client' => $client,
//             'token' => $token
//         ], 200);
//     }

//     return response()->json(['error' => 'Invalid credentials'], 401);
// }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) { // Use Auth::attempt
            $client = Auth::user(); // Retrieve the authenticated user

            // Check if the user's statut is between 0 and 1
            if ($client->statut == 0 || $client->statut == 1) {
                $token = $client->createToken('360TNAuth')->accessToken;

                // Return the entire user object along with the token
                return response()->json(['user' => $client, 'token' => $token], 200);
            } else {
                // If the user's statut is not between 0 and 1, return an error
                $errors = [];
                array_push($errors, ['code' => 'auth-003', 'message' => trans('messages.your_account_is_blocked')]);
                return response()->json(['errors' => $errors], 403);
            }
        } else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.X']);
            return response()->json(['errors' => $errors], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_et_prenom' => 'required',
            'email' => 'required|email|unique:client,email',
            'civilite' => 'nullable|string',
            'date_de_naissance1' => 'nullable|string',
            'date_de_naissance2' => 'nullable|string',
            'date_de_naissance3' => 'nullable|string',
            'date_de_naissance4' => 'nullable|string',
            'date_de_naissance' => 'nullable|date',
            'address' => 'nullable|string',
            'statut' => 'nullable|integer|between:0,1', // Ensure statut is between 0 and 1
            'code_postal' => 'nullable|string',
            'nom_enfant_1' => 'nullable|string',
            'nom_enfant_2' => 'nullable|string',
            'nom_enfant_3' => 'nullable|string',
            'nom_enfant_4' => 'nullable|string',
            'image' => 'nullable|string',
            'profession' => 'nullable|string',
            'situation_familiale' => 'nullable|string',
            'tel' => 'required|string|unique:clients,tel', // Corrected unique rule
            'verification_code' => 'nullable|string',
            'ville' => 'nullable|string',
            'gouvernorat' => 'nullable|string',
            'password' => 'required|string|min:6',
        ], [
            'nom_et_prenom.required' => 'The first name field is required.',
            'tel.required' => 'The phone field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $client = Client::create([
            'nom_et_prenom' => $request->nom_et_prenom,
            'email' => $request->email,
            'civilite' => $request->civilite,
            'date_de_naissance1' => $request->date_de_naissance1,
            'date_de_naissance2' => $request->date_de_naissance2,
            'date_de_naissance3' => $request->date_de_naissance3,
            'date_de_naissance4' => $request->date_de_naissance4,
            'date_de_naissance' => $request->date_de_naissance,
            'address' => $request->address,
            'statut' => $request->statut,
            'code_postal' => $request->code_postal,
            'nom_enfant_1' => $request->nom_enfant_1,
            'nom_enfant_2' => $request->nom_enfant_2,
            'nom_enfant_3' => $request->nom_enfant_3,
            'nom_enfant_4' => $request->nom_enfant_4,
            'image' => $request->image,
            'profession' => $request->profession,
            'situation_familiale' => $request->situation_familiale,
            'tel' => $request->tel,
            'verification_code' => $request->verification_code,
            'ville' => $request->ville,
            'gouvernorat' => $request->gouvernorat,
            'password' => bcrypt($request->password),
        ]);

        $token = $client->createToken('360TNAuth')->accessToken;

        return response()->json(['token' => $token, 'is_tel_verified' => 0, 'tel_verify_end_url' => "api/v1/auth/verify-phone"], 200);
    }
}
