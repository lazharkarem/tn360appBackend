<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller; // Import the base Controller class from Laravel
use App\Models\FoodType;
use Illuminate\Http\Request;

class FoodTypeApiController extends Controller
{
    
    public function index()
    {
        // Get all food types
        $foodTypes = FoodType::all();

        // Return as JSON response
        return response()->json($foodTypes);
    }
}
