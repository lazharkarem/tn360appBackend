<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Zone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class ConfigController extends Controller
{
        public function geocode_api(Request $request)
{
    // Validate lat and lng
    $validator = Validator::make($request->all(), [
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json(['errors' => Helpers::error_processor($validator)], 403);
    }

    // Make the API request to Google Geocoding API
    $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
        'latlng' => $request->lat . ',' . $request->lng,
        'key' => env('GOOGLE_MAPS_API_KEY'),  // Use the environment variable for API key
    ]);

    // Decode the response
    $data = $response->json();

    // Check if the response contains results
    if (empty($data['results'])) {
        return response()->json(['error' => 'No results found'], 404);
    }

    // Initialize variables to store address components
    $address = '';
    $street = '';
    $country = '';
    $postalCode = '';
    $city = '';

    // Loop through the address components
    foreach ($data['results'][0]['address_components'] as $component) {
        // Find the country
        if (in_array('country', $component['types'])) {
            $country = $component['long_name'];
        }

        // Find the postal code
        if (in_array('postal_code', $component['types'])) {
            $postalCode = $component['long_name'];
        }

        // Find the street name
        if (in_array('route', $component['types'])) {
            $street = $component['long_name'];
        }

        // Find the locality (city)
        if (in_array('locality', $component['types'])) {
            $city = $component['long_name'];
        }

        // You can also capture the complete address if needed
        $address = $data['results'][0]['formatted_address'];
    }

    // Return the detailed address information
    return response()->json([
        'address' => $address,
        'street' => $street,
        'country' => $country,
        'postal_code' => $postalCode,
        'city' => $city
    ]);
}

//             public function geocode_api(Request $request)
// {
//     // Validate incoming request
//     $validator = Validator::make($request->all(), [
//         'lat' => 'required|numeric',
//         'lng' => 'required|numeric',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => Helpers::error_processor($validator)], 403);
//     }

//     // Make request to Google Geocoding API
//     $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
//         'latlng' => $request->lat . ',' . $request->lng,
//         'key' => env('GOOGLE_MAPS_API_KEY'), // Use environment variable for API key
//     ]);

//     // Decode response
//     $data = $response->json();

//     // Check if results are empty
//     if (empty($data['results'])) {
//         return response()->json(['error' => 'No results found'], 404);
//     }

//     // Initialize variables
//     $country = '';
//     $zipCode = '';
//     $street = '';
//     $town = '';

//     // Extract address components
//     foreach ($data['results'][0]['address_components'] as $component) {
//         if (in_array('country', $component['types'])) {
//             $country = $component['long_name'];
//         }
//         if (in_array('postal_code', $component['types'])) {
//             $zipCode = $component['long_name'];
//         }
//         if (in_array('route', $component['types'])) {
//             $street = $component['long_name'];
//         }
//         if (in_array('locality', $component['types']) || in_array('administrative_area_level_2', $component['types'])) {
//             $town = $component['long_name'];
//         }
//     }

//     // Return response
//     return response()->json([
//         'country' => $country,
//         'zip_code' => $zipCode,
//         'street' => $street,
//         'town' => $town
//     ]);
// }

        public function get_zone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $point = new Point($request->lat,$request->lng);
        $zones = Zone::contains('coordinates', $point)->latest()->get();
       /* if(count($zones)<1)
        {
            return response()->json(['message'=>trans('messages.service_not_available_in_this_area_now')], 404);
        }
        foreach($zones as $zone)
        {
            if($zone->status)
            {
                return response()->json(['zone_id'=>$zone->id], 200);
            }
        }*/
        //return response()->json(['message'=>trans('messages.we_are_temporarily_unavailable_in_this_area')], 403);
         return response()->json(['zone_id'=>1], 200);
    }

    public function place_api_autocomplete(Request $request)
    {
        $validator=validator::make($request->all(),[
            'search_text' => 'required',
        ]);
        if($validator->errors()->count()>0){
            return response()->json(
                ['errors'=>Helpers::error_processor($validator)],
                403);
        }
        $response=Http::get(
            'https://maps.googleapis.com/maps/api/place/autocomplete/json?input='
            .$request['search_text']
            .'&key='
            .'AIzaSyAFwGAsC3VUZYdxkEwB43DEf5tpSx4hAZg'
        );
        return $response->json();
    }

    public function place_api_details(Request $request)
    {
        $validator=validator::make($request->all(),[
            'placeid' => 'required',
        ]);
        if($validator->errors()->count()>0){
            return response()->json(
                ['errors'=>Helpers::error_processor($validator)],
                403);
        }
        $response=Http::get(
            'https://maps.googleapis.com/maps/api/place/details/json?placeid='
            .$request['placeid']
            .'&key='
            .'AIzaSyAFwGAsC3VUZYdxkEwB43DEf5tpSx4hAZg'
        );
        return $response->json();
    }

}
