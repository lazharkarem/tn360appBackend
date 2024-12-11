<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ProductController extends Controller
{
    // Fetch all products
    public function getAllProducts(Request $request)
    {
        $products = Article::all();

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
       public function get_popular_products(Request $request){

        $list = Article::where('type_id', 2)->take(10)->orderBy('created_at','DESC')->get();

                foreach ($list as $item){
                    $item['description']=strip_tags($item['description']);
                    $item['description']=$Content = preg_replace("/&#?[a-z0-9]+;/i"," ",$item['description']);
                    unset($item['selected_people']);
                    unset($item['people']);
                }

                 $data =  [
                    'total_size' => $list->count(),
                    'type_id' => 2,
                    'offset' => 0,
                    'products' => $list
                ];

         return response()->json($data, 200);

    }

    // Fetch recommended products
          public function get_recommended_products(Request $request){
        $list = Article::where('type_id', 3)->take(10)->orderBy('created_at','DESC')->get();

                foreach ($list as $item){
                    $item['description']=strip_tags($item['description']);
                    $item['description']=$Content = preg_replace("/&#?[a-z0-9]+;/i"," ",$item['description']);
                    unset($item['selected_people']);
                    unset($item['people']);
                }

                 $data =  [
                    'total_size' => $list->count(),
                    'type_id' => 3,
                    'offset' => 0,
                    'products' => $list
                ];

         return response()->json($data, 200);
    }

    // Fetch drinks
    public function getDrinks(Request $request)
    {
        return $this->getArticlesByType(4, 10); // Drinks have type_id = 4
    }

    // Fetch product details by ID
    public function getProductDetails($id)
    {
        $product = Article::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($this->transformProduct($product), 200);
    }

    // Fetch products by type with optional limit
    public function getArticlesByType($articleTypeId, $limit = null)
    {
        $query = Article::where('type_id', $articleTypeId)->orderBy('created_at', 'DESC');

        if ($limit) {
            $query->take($limit);
        }

        $products = $query->get();

        $transformedProducts = $products->map(function ($item) {
            return $this->transformProduct($item);
        });

        return response()->json([
            'total_size' => Article::where('type_id', $articleTypeId)->count(),
            'type_id' => $articleTypeId,
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
