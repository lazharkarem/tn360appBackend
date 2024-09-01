<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OffreController extends Controller
{


    public function get_offres(Request $request)
{
    // Retrieve all offres from the database
    $offre = Offre::all();

    // Modify the data as needed
    // For example, removing HTML tags and selected_people and people fields
    foreach ($offre as $offre) {
        // Modify the description field to remove HTML tags and special characters
        $offre->description = strip_tags($offre->description);
        $offre->description = preg_replace("/&#?[a-z0-9]+;/i", " ", $offre->description);

        // Unset selected_people and people fields
        unset($offre->selected_people);
        unset($offre->people);
    }

    // Prepare the response data
    $data = [
        'total_size' => $offre->count(),
        'offre' => $offre
    ];

    // Return a JSON response with the modified data and a success status
    return response()->json([
        'status' => 'success',
        'data' => $data,
    ], Response::HTTP_OK);
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
        // Fetch all offers from the Offre model
        $offre = Offre::all();

        // Return the offers as JSON response
        return response()->json([
            'status' => 'success',
            'data' => $offre,
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
        // Retrieve the resource by ID from the database
        $offre = Offre::find($id);

        // If the resource is not found, return a JSON response with a 404 status
        if (!$offre) {
            return response()->json([
                'status' => 'error',
                'message' => 'Resource not found',
            ], Response::HTTP_NOT_FOUND);
        }

        // Return a JSON response with the resource and a success status
        return response()->json([
            'status' => 'success',
            'data' => $offre,
        ]);
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
