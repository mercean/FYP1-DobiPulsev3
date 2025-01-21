<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BulkOrder;
use Illuminate\Support\Facades\Auth;

class BulkOrderController extends Controller
{
    // Display all bulk orders with pagination and optional filtering by status
    public function index(Request $request)
    {
        // Get all orders of the authenticated user with optional filtering by order status
        $ordersQuery = BulkOrder::where('user_id', Auth::id());

        // Optional filter by order status (pending, approved, completed)
        if ($request->has('status')) {
            $ordersQuery->where('status', $request->status);
        }

        // Pagination (default 10 items per page)
        $orders = $ordersQuery->paginate(10);

        // Get the total count of orders for the user
        $orderCount = $orders->count();

        // Pass orders, count, and status filter to the view
        return view('bulk_orders.index', compact('orders', 'orderCount'));
    }

    // Show the form for creating a new bulk order
    public function create()
    {
        return view('bulk_orders.create'); // Return to the create order view
    }

    // Store a new bulk order in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'cloth_type' => 'required|string|max:255',
            'load_kg' => 'required|numeric|min:1',  // Ensure load is positive
            'load_arrival_date' => 'required|date|after:today',  // Ensure the date is in the future
            'load_arrival_time' => 'required|date_format:H:i',
            'pickup_date' => 'required|date|after:load_arrival_date',  // Pickup after load arrival
            'pickup_time' => 'required|date_format:H:i',
        ]);

        // Create a new bulk order in the database
        BulkOrder::create([
            'cloth_type' => $request->cloth_type,
            'load_kg' => $request->load_kg,
            'load_arrival_date' => $request->load_arrival_date,
            'load_arrival_time' => $request->load_arrival_time,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'status' => 'pending',  // Automatically set as 'pending'
            'price' => 0,           // Default price set to 0 so user can't override
            'user_id' => Auth::id(), // Link the order to the logged-in user
        ]);

        // Redirect to the bulk orders index with a success message
        return redirect()->route('bulk.orders.index')->with('success', 'Bulk order created successfully!');
    }

    // Show the form for editing the bulk order
    public function edit($id)
    {
        $order = BulkOrder::findOrFail($id);
        return view('bulk_orders.edit', compact('order'));
    }

    // Update the bulk order
    public function update(Request $request, $id)
    {
        $order = BulkOrder::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'cloth_type' => 'required|string|max:255',
            'load_kg' => 'required|numeric|min:1',
            'load_arrival_date' => 'required|date|after:today',
            'load_arrival_time' => 'required|date_format:H:i',
            'pickup_date' => 'required|date|after:load_arrival_date',
            'pickup_time' => 'required|date_format:H:i',
        ]);

        // Update the bulk order
        // Note: We do NOT allow the user to update the price or status here;
        // only the admin can do that from their dashboard.
        $order->update([
            'cloth_type' => $request->cloth_type,
            'load_kg' => $request->load_kg,
            'load_arrival_date' => $request->load_arrival_date,
            'load_arrival_time' => $request->load_arrival_time,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            // Retain existing status and price.
            'status' => $order->status,
            'price'  => $order->price,
        ]);

        return redirect()->route('bulk.orders.index')->with('success', 'Bulk order updated successfully!');
    }

    // Delete a bulk order
    public function destroy($id)
    {
        $order = BulkOrder::findOrFail($id);
        $order->delete();

        return redirect()->route('bulk.orders.index')->with('success', 'Order deleted successfully!');
    }
}
