<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class ProductController extends Controller
{
    // Fetch all products
    public function getAllProducts(Request $request)
    {
        $products = Food::all();

        $products = $products->map(function ($item) {
            return $this->transformProduct($item);
        });

        $data = [
            'total_size' => $products->count(),
            'products' => $products,
        ];

        return response()->json($data, 200);
    }

    // Fetch popular products
    public function getPopularProducts(Request $request)
    {
        return $this->getFoodsByType(2, 10); // Popular products have type_id = 2
    }

    // Fetch recommended products
    public function getRecommendedProducts(Request $request)
    {
        return $this->getFoodsByType(3, 10); // Recommended products have type_id = 3
    }

    // Fetch drinks
    public function getDrinks(Request $request)
    {
        return $this->getFoodsByType(4, 10); // Drinks have type_id = 4
    }

    // Fetch product details by ID
    public function getProductDetails($id)
    {
        $product = Food::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($this->transformProduct($product), 200);
    }

    // Fetch products by type with optional limit
    public function getFoodsByType($foodTypeId, $limit = null)
    {
        $query = Food::where('type_id', $foodTypeId)->orderBy('created_at', 'DESC');

        if ($limit) {
            $query->take($limit);
        }

        $products = $query->get();

        $transformedProducts = $products->map(function ($item) {
            return $this->transformProduct($item);
        });

        return response()->json([
            'total_size' => Food::where('type_id', $foodTypeId)->count(),
            'type_id' => $foodTypeId,
            'products' => $transformedProducts,
        ], 200);
    }

    // Helper function to transform product details
    private function transformProduct($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => preg_replace("/&#?[a-z0-9]+;/i", " ", strip_tags($product->description)),
            'price' => $product->price,
            'img' => $product->img, // Include image if necessary
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
    }
}
