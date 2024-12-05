<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealDepense;
use App\Models\Client;
use Validator;

class DealDepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getDealDepenseInfo(Request $request)
    {
        $dealDepense = DealDepense::all();
        return response()->json($dealDepense);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'ID_client' => 'required|exists:clients,ID_client',
            'segments' => 'required|string',
            'objectif_1' => 'required|numeric|min:0',
            'objectif_2' => 'required|numeric|min:0',
            'objectif_3' => 'required|numeric|min:0',
            'objectif_4' => 'required|numeric|min:0',
            'objectif_5' => 'required|numeric|min:0',
            'gain_objectif_1' => 'required|numeric|min:0',
            'gain_objectif_2' => 'required|numeric|min:0',
            'gain_objectif_3' => 'required|numeric|min:0',
            'gain_objectif_4' => 'required|numeric|min:0',
            'gain_objectif_5' => 'required|numeric|min:0',
            'compteur_objectif' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400); // Bad Request
        }

        // Create the new DealDepense record
        $dealDepense = DealDepense::create([
            'ID_client' => $request->ID_client,
            'segments' => $request->segments,
            'objectif_1' => $request->objectif_1,
            'objectif_2' => $request->objectif_2,
            'objectif_3' => $request->objectif_3,
            'objectif_4' => $request->objectif_4,
            'objectif_5' => $request->objectif_5,
            'gain_objectif_1' => $request->gain_objectif_1,
            'gain_objectif_2' => $request->gain_objectif_2,
            'gain_objectif_3' => $request->gain_objectif_3,
            'gain_objectif_4' => $request->gain_objectif_4,
            'gain_objectif_5' => $request->gain_objectif_5,
            'compteur_objectif' => $request->compteur_objectif,
        ]);

        return response()->json([
            'message' => 'Deal Depense created successfully!',
            'data' => $dealDepense,
        ], 201); // Created
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $dealDepense = DealDepense::find($id);

        // if (!$dealDepense) {
        //     return response()->json(['error' => 'Deal Depense not found.'], 404);
        // }

        // return response()->json($dealDepense);
    }

    // Other methods (update, destroy) can be added as needed
}
