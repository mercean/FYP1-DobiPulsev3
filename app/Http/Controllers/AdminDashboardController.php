<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\BulkOrder;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalBulkOrders = BulkOrder::count();

        // Fetch all regular orders and bulk orders
        $orders = Order::all();
        $bulkOrders = BulkOrder::all();

        // Return view with the data
        return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'totalBulkOrders', 'orders', 'bulkOrders'));
    }

    public function updateOrderStatus($id, $type, Request $request)
    {
        $status = $request->input('status');

        if ($type === 'order') {
            // Regular order
            $order = Order::findOrFail($id);
            $order->status = $status;
            $order->save();

        } elseif ($type === 'bulkOrder') {
            // Bulk order
            $bulkOrder = BulkOrder::findOrFail($id);

            // If 'price' is submitted, update the price (only relevant if status is 'approved', but adjust as needed)
            if ($request->filled('price')) {
                $bulkOrder->price = $request->input('price');
            }

            $bulkOrder->status = $status;
            $bulkOrder->save();
        }

        return redirect()->route('admin.dashboard')
                         ->with('status', 'Order status updated successfully!');
    }
}
