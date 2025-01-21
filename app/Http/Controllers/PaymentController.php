<?php

namespace App\Http\Controllers;

use App\Models\BulkOrder;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    // Initiate payment process
    public function initiatePayment(Request $request)
    {
        $order = BulkOrder::findOrFail($request->order_id);

        // Stripe configuration
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->price * 100, // Convert to cents
                'currency' => 'usd',
                'metadata' => ['order_id' => $order->id],
            ]);

            // Return the client secret to use in frontend
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Handle the payment success callback
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = BulkOrder::findOrFail($orderId);

        // Mark the order as 'completed'
        $order->status = 'completed';
        $order->save();

        // Log the payment success (for auditing purposes)
        \Log::info("Payment successful for order ID: {$order->id}");

        // Redirect back to the bulk orders index with a success message
        return redirect()->route('bulk.orders.index')->with('success', 'Payment successful!');
    }
}
