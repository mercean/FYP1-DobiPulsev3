@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow text-center">
            <h1 class="text-3xl font-bold text-green-600 mb-4">✅ Payment Successful</h1>

            <p class="text-xl text-gray-800 dark:text-gray-200">
                Your payment has been processed successfully!
            </p>

            <p class="text-gray-600 dark:text-gray-400 mt-4">
                Your bulk order is now confirmed. A receipt has been sent to your email (if provided).
            </p>

            <div class="mt-6">
                <a href="{{ route('bulk.orders.index') }}" 
                   class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                    🔁 Back to Bulk Orders
                </a>
            </div>
        </div>
    </div>
@endsection
