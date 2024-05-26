<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offre;

class OffreController extends Controller
{
    public function getDealOffreInfo(Request $request)
    {
        $offre = Offre::all();
        return response()->json($offre);
    }
}
