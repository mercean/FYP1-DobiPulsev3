<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Models\BulkOrder;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\LoyaltyPoint;
use App\Models\Machine;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Carbon\Carbon;
use App\Mail\PaymentReceipt;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MarkMachineAvailable;
use App\Models\Promotion;
use App\Notifications\PromotionAvailable;
use App\Notifications\LoyaltyPointsUpdated;
use App\Notifications\OrderStatusUpdated;

class PaymentController extends Controller
{
    // 🔹 Bulk Order Payment (Stripe USD)
    public function initiatePayment(Request $request)
    {
        $order = BulkOrder::findOrFail($request->order_id);
        Stripe::setApiKey(Config::get('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->price * 100,
                'currency' => 'usd',
                'metadata' => ['order_id' => $order->id],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = BulkOrder::findOrFail($orderId);

        $order->status = 'processing';
        $order->save();

        \Log::info("Payment successful for order ID: {$order->id}");

        return redirect()->route('bulk.orders.index')->with('success', 'Payment successful!');
    }

    public function regularPaymentPage(Order $order)
    {
        $user = auth()->user();
        $coupons = Coupon::where('user_id', $user->id)->where('used', false)->get();

        return view('orders.regular_payment', compact('order', 'coupons'));
    }

    public function regularPaymentMultiPage(Request $request)
    {
        $user = auth()->user();
        $ids = explode(',', $request->query('order_ids'));
        $orders = Order::whereIn('id', $ids)->where('user_id', $user->id)->get();

        $coupons = Coupon::where('user_id', $user->id)->where('used', false)->get();

        return view('orders.regular_payment', compact('orders', 'coupons'));
    }

    public function regularInitiate(Request $request)
    {
        \Log::info('💳 INITIATE START', $request->all());

        try {
            $order = Order::findOrFail($request->order_id);
            $discountAmount = 0;
            $promoApplied = null;

            if ($request->coupon) {
                $coupon = Coupon::where('code', $request->coupon)
                    ->where('user_id', $order->user_id)
                    ->where('used', false)
                    ->first();

                if ($coupon) {
                    if ($coupon->type === 'fixed') {
                        $discountAmount = floatval($coupon->value);
                    } elseif ($coupon->type === 'percent') {
                        $discountAmount = $order->total_amount * (floatval($coupon->value) / 100);
                    }

                    $coupon->used = true;
                    $coupon->save();
                }
            } else {
                $autoPromo = Promotion::where('auto_apply', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();

                if ($autoPromo) {
                    $promoApplied = $autoPromo;

                    if ($autoPromo->type === 'fixed') {
                        $discountAmount = floatval($autoPromo->value);
                    } elseif ($autoPromo->type === 'percent') {
                        $discountAmount = $order->total_amount * (floatval($autoPromo->value) / 100);
                    }
                }
            }

            $finalAmount = max(0, $order->total_amount - $discountAmount);
            \Log::info("🧾 Final Amount for Stripe: RM$finalAmount");

            Stripe::setApiKey(Config::get('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $finalAmount * 100,
                'currency' => 'myr',
                'metadata' => [
                    'order_id' => $order->id,
                    'discount_applied' => $discountAmount,
                    'coupon_code' => $request->coupon ?? ($promoApplied->code ?? 'auto-applied'),
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Throwable $e) {
            \Log::error('💥 Payment Initiate Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function regularSuccess(Request $request)
    {
        $orderIds = $request->query('order_ids');

        if ($orderIds) {
            $ids = explode(',', $orderIds);
            $orders = Order::whereIn('id', $ids)->get();

            foreach ($orders as $order) {
                $order->status = 'approved';
                $order->end_time = Carbon::now()->addMinutes($order->required_time);
                $order->save();

                \App\Jobs\MarkMachineAvailable::dispatch($order->id)->delay($order->end_time);

                if ($order->machine_id) {
                    $machine = Machine::find($order->machine_id);
                    if ($machine) {
                        $machine->status = 'in_use';
                        $machine->save();
                    }
                }

                $points = ($order->required_time / 30) * 50;
                $loyalty = LoyaltyPoint::firstOrNew(['user_id' => $order->user_id]);
                $loyalty->points = ($loyalty->points ?? 0) + $points;
                $loyalty->expiry_date = now()->addMonths(6);
                $loyalty->save();

                $order->load('user');
                Mail::to($order->user->email)->send(new PaymentReceipt($order));

                // ✅ Notify user
                $order->user->notify(new OrderStatusUpdated($order, 'Approved', 'regular'));
                $order->user->notify(new LoyaltyPointsUpdated($points));

                // ✅ Promotion notice
                $promo = Promotion::where('auto_apply', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();
                if ($promo) {
                    $order->user->notify(new PromotionAvailable($promo));
                }
            }

            return view('orders.payment_success', compact('orders'));
        }

        $order = Order::findOrFail($request->order_id);
        $order->status = 'approved';
        $order->end_time = Carbon::now()->addMinutes($order->required_time);
        $order->save();

        \App\Jobs\MarkMachineAvailable::dispatch($order->id)->delay($order->end_time);

        if ($order->machine_id) {
            $machine = Machine::find($order->machine_id);
            if ($machine) {
                $machine->status = 'in_use';
                $machine->save();
            }
        }

        $points = ($order->required_time / 30) * 50;
        $loyalty = LoyaltyPoint::firstOrNew(['user_id' => $order->user_id]);
        $loyalty->points = ($loyalty->points ?? 0) + $points;
        $loyalty->expiry_date = now()->addMonths(6);
        $loyalty->save();

        $order->load('user');
        Mail::to($order->user->email)->send(new PaymentReceipt($order));

        $order->user->notify(new OrderStatusUpdated($order, 'Approved', 'regular'));
        $order->user->notify(new LoyaltyPointsUpdated($points));

        $promo = Promotion::where('auto_apply', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
        if ($promo) {
            $order->user->notify(new PromotionAvailable($promo));
        }

        \Log::info("✅ Single order approved", $order->toArray());

        return view('orders.payment_success', compact('order'));
    }
}
