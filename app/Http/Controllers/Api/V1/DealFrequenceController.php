<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealFrequence;
use App\Models\Client;

class DealFrequenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getDealFrequenceInfo(Request $request)
    {
        $dealFrequence = DealFrequence::all();
        return response()->json($dealFrequence);
    }


    /**
     * Calculate deal frequency for a specific client.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $clientId
     * @return \Illuminate\Http\JsonResponse
     */
public function calculateDealFrequence(Request $request, $clientId)
{
    // Fetch the DealFrequence record for the client
    $dealFrequence = DealFrequence::where('ID_client', $clientId)->first();

    if (!$dealFrequence) {
        return response()->json(['error' => 'DealFrequence record not found'], 404);
    }

    // Get panier_moyen (average basket value) from the deal_frequence table
    $panierMoyen = (float)trim($dealFrequence->panier_moyen); // Now fetching panier_moyen from deal_frequence

    // Initialize compteur_frequence to 0 by default
    $compteurFrequence = 0;

    // Check each commande field from 1 to 4
    $commandes = [
        (float)trim($dealFrequence->commande_1), // Clean and cast to float
        (float)trim($dealFrequence->commande_2),
        (float)trim($dealFrequence->commande_3),
        (float)trim($dealFrequence->commande_4),
    ];

    // Loop through the commandes and check if any is >= panier_moyen
    foreach ($commandes as $commande) {
        if ($commande >= $panierMoyen) {
            $compteurFrequence++;
        }
    }

    // Update the dealFrequence with the calculated compteur_frequence
    $dealFrequence->compteur_frequence = $compteurFrequence;
    $dealFrequence->save();

    // Return response with updated data
    return response()->json([
        'success' => true,
        'data' => [
            'client_id' => $clientId,
            'compteur_frequence' => $compteurFrequence,
            'deal_frequence' => $dealFrequence,
        ],
    ]);
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
