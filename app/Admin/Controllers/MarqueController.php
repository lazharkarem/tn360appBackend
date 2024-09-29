<?php

namespace App\Admin\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marque;

class MarqueController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nomMarque' => 'required|string',
            'logo' => 'nullable|string',
            'teleMarque' => 'nullable|string',
            'emailMarque' => 'required|email',
            'contrat' => 'nullable|string',
        ]);

        // Create a new marque record
        $marque = Marque::create($request->all());

        return response()->json($marque, 201);
    }

    public function delete($id)
    {
        // Find the marque by ID
        $marque = Marque::findOrFail($id);

        // Delete the marque
        $marque->delete();

        return response()->json(null, 204);
    }

    public function edit(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'nomMarque' => 'required|string',
            'logo' => 'nullable|string',
            'teleMarque' => 'nullable|string',
            'emailMarque' => 'required|email',
            'contrat' => 'nullable|string',
        ]);

        // Find the marque by ID
        $marque = Marque::findOrFail($id);

        // Update the marque
        $marque->update($request->all());

        return response()->json($marque, 200);
    }

    public function index()
{
    // Fetch "marque" records from the database
    $marque = Marque::all();

    // Pass the "marque" data to the view
    return view('manage_marques', compact('marques'));
}

}
