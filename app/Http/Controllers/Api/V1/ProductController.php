<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class ProductController extends Controller
{


      // New method to fetch all products
    public function getAllProducts(Request $request)
    {
        $list = Food::all();

        foreach ($list as $item) {
            $item = $this->cleanDescription($item);
        }

        $data = [
            'total_size' => $list->count(),
            'products' => $list
        ];

        return response()->json($data, 200);
    }

    public function get_popular_products(Request $request){

        $list = Food::where('type_id', 2)->take(10)->orderBy('created_at','DESC')->get();

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
        public function get_recommended_products(Request $request){
        $list = Food::where('type_id', 3)->take(10)->orderBy('created_at','DESC')->get();

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


       public function test_get_recommended_products(Request $request){

        $list = Food::skip(5)->take(2)->get();

        foreach ($list as $item){
            $item['description']=strip_tags($item['description']);
            $item['description']=$Content = preg_replace("/&#?[a-z0-9]+;/i"," ",$item['description']);
        }

         $data =  [
            'total_size' => $list->count(),
            'limit' => 5,
            'offset' => 0,
            'products' => $list
        ];
         return response()->json($data, 200);
        // return json_decode($list);
    }



     public function get_drinks(Request $request){
        $list = Food::where('type_id', 4)->take(10)->orderBy('created_at','DESC')->get();

                foreach ($list as $item){
                    $item['description']=strip_tags($item['description']);
                    $item['description']=$Content = preg_replace("/&#?[a-z0-9]+;/i"," ",$item['description']);
                    unset($item['selected_people']);
                    unset($item['people']);
                }

                 $data =  [
                    'total_size' => $list->count(),
                    'type_id' => 4,
                    'offset' => 0,
                    'products' => $list
                ];

         return response()->json($data, 200);
    }

      // Common method for fetching and formatting products by type
      public function getFoodsByType($foodTypeId)
    {
        $foods = Food::where('type_id', $foodTypeId)->get();
        $foods = $foods->map(function($item) {
            return $this->cleanDescription($item);
        });

        return response()->json($foods);
    }

    // Method to clean the description
private function cleanDescription($product)
{
    $product['description'] = strip_tags($product['description']);
    $product['description'] = preg_replace("/&#?[a-z0-9]+;/i", " ", $product['description']);
    unset($product['selected_people']);
    unset($product['people']);
    
    return $product;
}

public function getProductDetails($id)
{
    // Fetch the product by ID
    $product = Food::find($id);

    // If product not found, return a 404 response
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // Clean the description and unset unwanted fields
    $product = $this->cleanDescription($product);

    return response()->json($product, 200);
}




}
