<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\Article;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function place_order(Request $request)
{
    // Validation logic for required fields
    $validator = Validator::make($request->all(), [
        'order_amount' => 'required',
        'address' => 'required_if:order_type,delivery',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => Helpers::error_processor($validator)], 403);
    }

    // Get the user and their cagnotte balance
    $user = $request->user();
    $cagnotteBalance = $user->cagnotte_balance; // Assuming 'cagnotte_balance' is a field in your User model
    
    // Initialize address and product price
    $address = [
        'contact_person_name' => $request->contact_person_name ?: ($request->user()->nom_et_prenom . ' ' . $request->user()->nom_et_prenom),
        'contact_person_number' => $request->contact_person_number ?: $request->user()->tel,
        'address' => $request->address,
        'longitude' => (string)$request->longitude,
        'latitude' => (string)$request->latitude,
    ];

    $product_price = 0;
    $order_details = [];

    // Calculate total price from cart items
    foreach ($request['cart'] as $c) {
        $product = Article::find($c['id']);
        if ($product) {
            $price = $product['price'];
            $or_d = [
                'article_id' => $c['id'],
                'article_details' => json_encode($product),
                'quantity' => $c['quantity'],
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
                'tax_amount' => 10.0,
            ];

            $product_price += $price * $or_d['quantity'];
            $order_details[] = $or_d;
        } else {
            return response()->json([
                'errors' => [
                    ['code' => 'article', 'message' => 'not found!']
                ]
            ], 401);
        }
    }

    // Initialize the total price
    $total_price = $product_price;

    // Check if cagnotte is selected and if the balance is sufficient
    if ($request->payment_method == 'cagnotte') {
        // If the cagnotte balance is sufficient, deduct it from the total price
        if ($cagnotteBalance >= $total_price) {
            $total_price -= $cagnotteBalance;
            $user->cagnotte_balance = 0; // Deduct the full cagnotte balance
        } else {
            // If the cagnotte balance is insufficient, return an error
            return response()->json([
                'errors' => [
                    ['code' => 'insufficient_balance', 'message' => 'Insufficient cagnotte balance']
                ]
            ], 403);
        }
    }

    // Create the order
    $order = new Order();
    $order->id = 100000 + Order::all()->count() + 1; // Generate order ID
    $order->ID_client = $user->ID_client; // Set client ID
    $order->order_amount = $total_price; // Use the updated total price
    $order->order_note = $request['order_note']; // Order note
    $order->delivery_address = json_encode($address); // Delivery address
    $order->otp = rand(1000, 9999); // OTP for verification
    $order->pending = now(); // Order pending timestamp
    $order->created_at = now(); // Order creation timestamp
    $order->updated_at = now(); // Order update timestamp
    $order->order_type = $request['order_type']; // Order type (delivery or pickup)
    $order->payment_status = $request['payment_method'] == 'wallet' ? 'paid' : 'unpaid'; // Set payment status
    $order->order_status = $request['payment_method'] == 'digital_payment' ? 'failed' :
        ($request->payment_method == 'wallet' ? 'confirmed' : 'pending'); // Order status
    $order->payment_method = $request->payment_method; // Payment method (cagnotte, wallet, etc.)

    // Save the order and order details
    try {
        $save_order = $order->id;
        $order->save();

        // Insert order details
        foreach ($order_details as $key => $item) {
            $order_details[$key]['order_id'] = $order->id;
        }
        OrderDetail::insert($order_details);

        // Send notification (using Firebase or other service)
        Helpers::send_order_notification($order, $user->cm_firebase_token);

        return response()->json([
            'message' => trans('messages.order_placed_successfully'),
            'order_id' => $save_order,
            'total_amount' => $total_price,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([$e], 403);
    }

    return response()->json([
        'errors' => [
            ['code' => 'order_time', 'message' => trans('messages.failed_to_place_order')]
        ]
    ], 403);
}


    public function get_order_list(Request $request)
    {
        // Fetch the orders placed by the user
        $orders = Order::withCount('details')->where(['ID_client' => $request->user()->ID_client])->get()->map(function ($data) {
            $data['delivery_address'] = $data['delivery_address'] ? json_decode($data['delivery_address']) : $data['delivery_address'];
            return $data;
        });

        return response()->json($orders, 200);
    }
}
