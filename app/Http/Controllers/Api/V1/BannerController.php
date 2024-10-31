<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller; // Import the base Controller class from Laravel
use App\Models\Banner; // Import the Banner model
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        // Get all banners
        $banners = Banner::all();

        // Return as JSON response
        return response()->json($banners);
    }
}
