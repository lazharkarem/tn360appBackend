<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client; // Changed to Client model as you're working with clients
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
{
    // Handle callback if it's present
    if ($request->has('callback')) {
        Order::where(['id' => $request->order_id])->update(['callback' => $request['callback']]);
    }

    // Store session data
    session()->put('customer_id', $request['customer_id']);
    session()->put('order_id', $request->order_id);

    // Retrieve the customer and order information
    $customer = Client::find($request['customer_id']);  // Use Client model for 'client' table
    $order = Order::where(['id' => $request->order_id, 'ID_client' => $request['customer_id']])->first();

    if (isset($customer) && isset($order)) {
        // Save the customer info in the session for use in payment-view
        $data = [
            'name' => $customer['nom_et_prenom'],
            'email' => $customer['email'],
            'phone' => $customer['tel'],
        ];
        session()->put('data', $data);
        return view('payment-view');
    }

    return response()->json(['errors' => ['code' => 'order-payment', 'message' => 'Data not found']], 403);
}


    public function success()
{
    // Retrieve the order using session data
    $order = Order::where(['id' => session('order_id'), 'ID_client' => session('customer_id')])->first();

    if ($order) {
        // Here, check if the payment was done via Cagnotte and deduct from the balance
        $client = $order->client;  // Access the related client from the order model
        $orderAmount = $order->order_amount;  // Get the order amount

        // Assuming the payment method is Cagnotte
        if ($client->cagnotte >= $orderAmount) {
            // Deduct the amount from cagnotte
            $client->deductFromCagnotte($orderAmount);
            // Mark order as paid
            $order->status = 'paid';  // You may want to set this status
            $order->save();
        } else {
            // If not enough funds in cagnotte, you can handle this case here
            return redirect()->route('payment.fail')->with('error', 'Insufficient funds in cagnotte.');
        }
    }

    // Clear session data
    session()->forget(['customer_id', 'order_id', 'data']);

    // Redirect to callback URL if it exists
    $callbackUrl = $order->callback ?? null;
    if ($callbackUrl) {
        return redirect($callbackUrl . '&status=success');
    }

    return response()->json(['message' => 'Payment succeeded'], 200);
}


    public function fail()
{
    // Retrieve the order using session data
    $order = Order::where(['id' => session('order_id'), 'ID_client' => session('customer_id')])->first();

    // Clear session data
    session()->forget(['customer_id', 'order_id', 'data']);

    // Redirect to callback URL if it exists
    $callbackUrl = $order->callback ?? null;
    if ($callbackUrl) {
        return redirect($callbackUrl . '&status=fail');
    }

    return response()->json(['message' => 'Payment failed'], 403);
}

}
