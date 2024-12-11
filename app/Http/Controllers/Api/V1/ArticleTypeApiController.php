<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller; // Import the base Controller class from Laravel
use App\Models\ArticleType;
use Illuminate\Http\Request;

class ArticleTypeApiController extends Controller
{
    
    public function index()
    {
        $articleTypes = ArticleType::all();

        // Return as JSON response
        return response()->json($articleTypes);
    }
}
