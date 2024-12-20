<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CagnotteDepot;
use Illuminate\Http\Request;

class CagnotteController extends Controller
{
    public function store(Request $request)
    {
        // Ensure the client exists
        $client = Client::find($request->client_id);

        if (!$client) {
            return response()->json(['status' => 'error', 'message' => 'Client not found']);
        }

        // Create a new CagnotteDepot (Deposit)
        $cagnotteDepot = new CagnotteDepot();
        $cagnotteDepot->ID_client = $client->ID_client;
        $cagnotteDepot->amount_depot = $request->amount;
        $cagnotteDepot->save();

        // Update the client's cagnotte balance
        $client->increment('cagnotte_balance', $request->amount);

        return response()->json(['status' => 'success', 'message' => 'Cagnotte deposit successful']);
    }
}
