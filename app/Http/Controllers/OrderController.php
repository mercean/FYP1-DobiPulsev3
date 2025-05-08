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
    // Show the New Order Placement Form
    public function createOrder()
    {
        $machines = Machine::with('active_order')->get();
    
        return view('dashboard.new_order', compact('machines'));
    }
    
    

    // Store the order after form submission
    public function store(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|integer|exists:machines,id',
            'required_time' => 'required|integer|min:30|max:120',
            'total_price' => 'required|numeric',
        ]);
    
        $userId = auth()->id();
        $price = $request->total_price;
        $requiredTime = $request->required_time;
        $machineId = $request->machine_id;
    
        // 🔐 Check if machine is still available
        $machine = Machine::where('id', $machineId)->where('status', 'available')->first();
    
        if (!$machine) {
            return redirect()->back()->with('error', 'Selected machine is no longer available.');
        }
    
        // 🔒 Lock the machine early to prevent race conditions
        $machine->status = 'in_use';
        $machine->save();
    
        // 🧾 Generate unique order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(6));
    
        // 📝 Create the new order
        $order = Order::create([
            'user_id' => $userId,
            'order_number' => $orderNumber,
            'machine_id' => $machineId,
            'required_time' => $requiredTime,
            'total_amount' => $price,
            'status' => 'pending',
        ]);
    
        return redirect()->route('payment.regular.page', ['order' => $order->id]);
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

}
