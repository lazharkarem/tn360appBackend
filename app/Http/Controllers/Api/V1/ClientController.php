<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\DealHistorique;
use App\Models\OffreHistorique;


class ClientController extends Controller
{
    public function address_list(Request $request)
    {
        return response()->json(ClientAddress::where('ID_client', $request->user()->ID_client)->latest()->get(), 200);
    }

   public function info(Request $request)
    {
        $data = $request->user();

        $data['order_count'] =0;//(integer)$request->user()->orders->count();
        $data['member_since_days'] =(integer)$request->user()->created_at->diffInDays();
        //unset($data['orders']);
        return response()->json($data, 200);
    }

    public function add_new_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "Error with the address"], 403);
        }

        $address = [
            'ID_client' => $request->user()->ID_client, // Use ID_client
            'contact_person_name' => $request->contact_person_name,
            'contact_person_number' => $request->contact_person_number,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'created_at' => now(),
            'updated_at' => now()
        ];

        ClientAddress::create($address); // Use the Eloquent model for insertion

        return response()->json(['message' => trans('messages.successfully_added')], 200);
    }

    public function update_address(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }

        // Update the correct table and reference the right columns
        $address = [
            'ID_client' => $request->user()->ID_client,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_number' => $request->contact_person_number,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'updated_at' => now() // No need to set created_at on update
        ];

        ClientAddress::where('id', $id)->update($address); // Use the correct ID for the update

        return response()->json(['message' => trans('messages.updated_successfully')], 200);
    }

    public function updateCmFirebaseToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cm_firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }

        DB::table('client')->where('ID_client', $request->user()->ID_client)->update([
            'cm_firebase_token' => $request['cm_firebase_token']
        ]);

        return response()->json(['message' => trans('messages.updated_successfully')], 200);
    }



public function updateCagnotte(Request $request)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'cagnotte_balance' => 'required|numeric|min:0',
    ]);

    // Return validation errors if they occur
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 403);
    }

    // Get the authenticated client
    $client = $request->user();

    // Safely add the provided balance to the existing balance
    $newBalance = $client->cagnotte_balance + $request->input('cagnotte_balance');

    // Update the client's cagnotte_balance
    $client->cagnotte_balance = $newBalance;

    // Save the changes
    $client->save();

    return response()->json([
        'message' => 'Cagnotte updated successfully',
        'new_balance' => $newBalance
    ], 200);
}


public function dealHistory(Request $request)
    {
        $clientId = $request->user()->ID_client;

        $dealHistory = DealHistorique::where('ID_client', $clientId)
            ->orderBy('date_debut', 'desc')
            ->get();

        return response()->json([
            'data' => $dealHistory,
        ], 200);
    }

    public function offerHistory(Request $request)
    {
        $clientId = $request->user()->ID_client;

        $offerHistory = OffreHistorique::where('ID_client', $clientId)
            ->orderBy('date_debut', 'desc')
            ->get();

        return response()->json([
            'data' => $offerHistory,
        ], 200);
    }


    

}
