<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $client = Auth::guard('sanctum')->user(); // Get the authenticated client

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        // Validation rules for profile update
        $validator = Validator::make($request->all(), [
            'nom_et_prenom' => 'nullable|string',
            'civilite' => 'nullable|string',
            'date_de_naissance1' => 'nullable|string',
            'date_de_naissance2' => 'nullable|string',
            'date_de_naissance3' => 'nullable|string',
            'date_de_naissance4' => 'nullable|string',
            'date_de_naissance' => 'nullable|date',
            'address' => 'nullable|string',
            'statut' => 'nullable|integer|between:0,1',
            'code_postal' => 'nullable|string',
            'nom_enfant_1' => 'nullable|string',
            'nom_enfant_2' => 'nullable|string',
            'nom_enfant_3' => 'nullable|string',
            'nom_enfant_4' => 'nullable|string',
            'image' => 'nullable|string',
            'profession' => 'nullable|string',
            'situation_familiale' => 'nullable|string',
            'tel' => 'nullable|string|unique:client,tel,' . $client->ID_client . ',ID_client',// Allow unique tel except for the current client
            'verification_code' => 'nullable|string',
            'ville' => 'nullable|string',
            'gouvernorat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        // Update the client's profile with the provided data
        $client->update([
            'nom_et_prenom' => $request->nom_et_prenom ?? $client->nom_et_prenom,
            'civilite' => $request->civilite ?? $client->civilite,
            'date_de_naissance1' => $request->date_de_naissance1 ?? $client->date_de_naissance1,
            'date_de_naissance2' => $request->date_de_naissance2 ?? $client->date_de_naissance2,
            'date_de_naissance3' => $request->date_de_naissance3 ?? $client->date_de_naissance3,
            'date_de_naissance4' => $request->date_de_naissance4 ?? $client->date_de_naissance4,
            'date_de_naissance' => $request->date_de_naissance ?? $client->date_de_naissance,
            'address' => $request->address ?? $client->address,
            'statut' => $request->statut ?? $client->statut,
            'code_postal' => $request->code_postal ?? $client->code_postal,
            'nom_enfant_1' => $request->nom_enfant_1 ?? $client->nom_enfant_1,
            'nom_enfant_2' => $request->nom_enfant_2 ?? $client->nom_enfant_2,
            'nom_enfant_3' => $request->nom_enfant_3 ?? $client->nom_enfant_3,
            'nom_enfant_4' => $request->nom_enfant_4 ?? $client->nom_enfant_4,
            'image' => $request->image ?? $client->image,
            'profession' => $request->profession ?? $client->profession,
            'situation_familiale' => $request->situation_familiale ?? $client->situation_familiale,
            'tel' => $request->tel ?? $client->tel,
            'verification_code' => $request->verification_code ?? $client->verification_code,
            'ville' => $request->ville ?? $client->ville,
            'gouvernorat' => $request->gouvernorat ?? $client->gouvernorat,
        ]);

        return response()->json(['message' => 'Profile updated successfully', 'client' => $client], 200);
    }
}
