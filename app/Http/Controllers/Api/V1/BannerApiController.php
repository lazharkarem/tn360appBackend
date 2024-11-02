<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller; // Import the base Controller class from Laravel
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerApiController extends Controller
{
    
    public function index()
    {
        $banners = Banner::all();

        // Return as JSON response
        return response()->json($banners);
    }
}
