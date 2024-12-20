<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function payment(Request $request)
    {
        if ($request->has('callback')) {
            Order::where(['id' => $request->order_id])->update(['callback' => $request['callback']]);
        }

        session()->put('customer_id', $request['customer_id']);
        session()->put('order_id', $request->order_id);

        $customer = Client::find($request['customer_id']);
        $order = Order::where(['id' => $request->order_id, 'ID_client' => $request['customer_id']])->first();

        // Check if the customer and order exist
        if (isset($customer) && isset($order)) {
            // Check if the customer wants to use their cagnotte balance
            if ($request->has('use_cagnotte') && $request->use_cagnotte == 'true') {
                // Ensure the client has enough cagnotte balance
                if ($customer->cagnotte_balance >= $order->order_amount) {
                    // Deduct the amount from the client's cagnotte balance
                    $customer->decrement('cagnotte_balance', $order->order_amount);

                    // Create a CagnotteRetrait entry for the transaction history
                    \App\Models\CagnotteRetrait::create([
                        'order_id' => $order->id,
                        'ID_client' => $customer->ID_client,
                        'amount_retrait' => $order->order_amount
                    ]);

                    // Update the order's payment status
                    $order->update(['payment_status' => 'paid']);

                    return redirect()->route('payment.success');
                } else {
                    return response()->json(['error' => 'Not enough cagnotte balance'], 400);
                }
            }

            $data = [
                'name' => $customer['f_name'],
                'email' => $customer['email'],
                'phone' => $customer['phone'],
            ];
            session()->put('data', $data);
            return view('payment-view');
        }

        return response()->json(['errors' => ['code' => 'order-payment', 'message' => 'Data not found']], 403);
    }


    public function payWithCagnotte(Request $request)
{
    $order = Order::find($request->order_id);
    $client = $order->client;

    // Check if the client has enough cagnotte balance
    if ($client->cagnotte_balance >= $order->order_amount) {
        // Deduct the order amount from cagnotte balance
        $client->decrement('cagnotte_balance', $order->order_amount);

        // Create a CagnotteRetrait entry for history
        \App\Models\CagnotteRetrait::create([
            'order_id' => $order->id,
            'ID_client' => $client->ID_client,
            'amount_retrait' => $order->order_amount
        ]);

        // Update the order as paid
        $order->update([
            'payment_status' => 'paid'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Order paid using cagnotte']);
    } else {
        return response()->json(['status' => 'error', 'message' => 'Not enough cagnotte balance']);
    }
}



    public function success()
    {
        $order = Order::where(['id' => session('order_id'), 'ID_client' => session('customer_id')])->first();

        // Check if the order exists and is marked as 'paid'
        if ($order && $order->payment_status == 'paid') {
            // Optional: Redirect to the callback URL if provided
            if ($order->callback != null) {
                return redirect($order->callback . '&status=success');
            }

            return response()->json(['message' => 'Payment succeeded'], 200);
        }

        return redirect()->route('payment.fail');
    }


    public function fail()
{
    $order = Order::where(['id' => session('order_id'), 'ID_client' => session('customer_id')])->first();

    // Optional: Redirect to the callback URL if provided
    if ($order && $order->callback != null) {
        return redirect($order->callback . '&status=fail');
    }

    return response()->json(['message' => 'Payment failed'], 400);
}

}