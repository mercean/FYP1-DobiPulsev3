@extends('layouts.master')

@section('title', 'Order Details')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mt-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">🧾 Order #{{ $order->id }} Details</h2>

    <div class="mb-4">
        <p><span class="font-semibold text-gray-700 dark:text-gray-200">Status:</span> {{ ucfirst($order->status) }}</p>
        <p><span class="font-semibold text-gray-700 dark:text-gray-200">Type:</span> {{ $order->type }}</p>
        <p><span class="font-semibold text-gray-700 dark:text-gray-200">Total Price:</span> RM {{ number_format($order->total_price, 2) }}</p>
        <p><span class="font-semibold text-gray-700 dark:text-gray-200">Loyalty Points:</span> {{ $order->points_awarded ?? 0 }}</p>
        <p><span class="font-semibold text-gray-700 dark:text-gray-200">Created:</span> {{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>

    @if ($order->machines && count($order->machines))
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Machines Used:</h3>
        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
            @foreach ($order->machines as $machine)
                <li>Machine #{{ $machine->id }} – {{ ucfirst($machine->type) }} @ {{ $machine->location }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <a href="{{ route('regular.orders') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        ← Back to Orders
    </a>
</div>
@endsection
