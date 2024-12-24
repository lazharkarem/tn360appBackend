<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealOffre;

class OffreController extends Controller
{
    public function getDealOffreInfo(Request $request)
    {
        $offre = DealOffre::all();
        return response()->json($offre);
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
        $validator = Validator::make($request->all(), [
            'ID_client' => 'required|exists:clients,ID_client',
            'type_offre' => 'required|string',
            'amount_earned' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $offre = Offre::create($request->all());

        return response()->json([
            'message' => 'Offre created successfully!',
            'data' => $offre,
        ], 201);
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
    $offre = DealOffre::findOrFail($id);

    $offre->update($request->all());

    if ($offre->statut === 'cloturee' || $offre->date_fin <= now()) {
        $offre->moveToHistorical();
    }

    return response()->json([
        'message' => 'Offre updated successfully!',
        'data' => $offre,
    ]);
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
