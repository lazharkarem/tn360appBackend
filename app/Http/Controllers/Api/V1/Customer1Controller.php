<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client; // Import the Client model
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Customer1Controller extends Controller
{
    public function addressList(Request $request)
    {
        $client = $request->user();
        $clientId = $client->ID_client;
        return response()->json(Client::find($clientId)->latest()->get(), 200);
    }

    public function info(Request $request)
    {
        $client = $request->user();
        $data = $client;

        $data['order_count'] = 0;
        $data['member_since_days'] = (integer)$client->created_at->diffInDays();

        return response()->json($data, 200);
    }

    public function addNewAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }

        $address = [
            'ID_client' => $request->user()->ID_client,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_number' => $request->contact_person_number,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('client_addresses')->insert($address);

        return response()->json(['message' => trans('messages.successfully_added')], 200);
    }

    public function updateAddress(Request $request, $id)
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

        $address = [
            'ID_client' => $request->user()->ID_client,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_number' => $request->contact_person_number,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'zone_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('client_addresses')->where('ID_client', $request->user()->ID_client)->update($address);

        return response()->json(['message' => trans('messages.updated_successfully'), 'zone_id' => $zone->id], 200);
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
}
