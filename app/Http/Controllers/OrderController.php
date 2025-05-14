<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Machine;
use App\Models\User;

class OrderController extends Controller
{
public function createOrder()
{
    $machines = Machine::with(['active_order' => function ($query) {
    $query->select('id', 'machine_id', 'status', 'end_time');
    }])->get();




    $orders = Order::where('user_id', auth()->id())
                   ->whereIn('status', ['pending', 'processing', 'approved'])
                   ->orderBy('created_at', 'desc')
                   ->get();

    $points = \App\Models\LoyaltyPoint::where('user_id', auth()->id())->sum('points');

    // Add this part to generate dummy or real chart data
    $chartData = [
        'labels' => [],
        'data' => [],
    ];

    foreach ($orders->take(5)->reverse() as $order) {
        $chartData['labels'][] = 'Order #' . $order->id;
        $chartData['data'][] = $order->total_amount;
    }

    return view('dashboard.new_order', compact('machines', 'orders', 'points', 'chartData'));
}

public function store(Request $request)
{
    $request->validate([
        'machine_ids'   => 'required|array',
        'machine_ids.*' => 'required|integer|exists:machines,id',
        'required_times' => 'required|array',
        'required_times.*' => 'required|integer|min:30|max:120',
        'total_price'   => 'required|numeric',
    ]);

    $userId = auth()->id();
    $orders = [];

    foreach ($request->machine_ids as $machineId) {
        $machine = Machine::where('id', $machineId)->where('status', 'available')->first();

        if (!$machine) {
            return redirect()->back()->with('error', "Machine #$machineId is no longer available.");
        }

        $time = (int) $request->required_times[$machineId];
        $rate = strtolower($machine->type) === 'dryer' ? 4.00 : 5.00;
        $price = ($time / 30) * $rate;

        $machine->status = 'in_use';
        $machine->save();

        $orderNumber = 'ORD-' . strtoupper(\Str::random(6));
        $orders[] = Order::create([
            'user_id'       => $userId,
            'order_number'  => $orderNumber,
            'machine_id'    => $machineId,
            'required_time' => $time,
            'total_amount'  => $price,
            'status'        => 'pending',
        ]);
    }

    return redirect()->route('payment.regular.page', ['order' => $orders[0]->id]);
}


    
    
        public function destroy($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $order->delete();

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
    // app/Models/Machine.php




}
