@extends('layouts.master')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4 py-10">
    <div class="w-full max-w-4xl">
        @if(isset($orders))
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center mb-6">
                    <h2 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">✅ Payment Successful!</h2>
                    <p class="text-lg text-gray-700 dark:text-gray-200 mb-2">Thank you for your payment.</p>
                    <p class="text-md text-gray-600 dark:text-gray-400 mb-6">
                        Your order <strong class="text-blue-600 dark:text-blue-400">#{{ $order->order_number ?? $order->id }}</strong> has been successfully placed.
                    </p>

                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-left mb-6">
                        <p><strong>🧾 Paid Amount:</strong> RM{{ number_format($order->total_amount, 2) }}</p>
                        <p><strong>Points Earned:</strong> {{ ($order->required_time / 30) * 50 }} pts</p>
                    </div>
                </div>
            @endforeach
        @elseif(isset($order))
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
                <h2 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">✅ Payment Successful!</h2>
                <p class="text-lg text-gray-700 dark:text-gray-200 mb-2">Thank you for your payment.</p>
                <p class="text-md text-gray-600 dark:text-gray-400 mb-6">
                    Your order <strong class="text-blue-600 dark:text-blue-400">#{{ $order->order_number ?? $order->id }}</strong> has been successfully placed.
                </p>

                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-left mb-6">
                    <p><strong>🧾 Paid Amount:</strong> RM{{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Points Earned:</strong> {{ ($order->required_time / 30) * 50 }} pts</p>
                </div>
            </div>
        @endif

        <div class="flex justify-center space-x-4 mt-6">
            <a href="{{ route('regular.dashboard') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow transition">
                🔙 Back to Dashboard
            </a>
            <a href="{{ route('orders.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow transition">
                ➕ Place Another Order
            </a>
        </div>
    </div>
</div>
@endsection
