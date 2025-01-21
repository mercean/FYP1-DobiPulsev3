@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-center text-3xl font-semibold text-gray-800 mb-8">Payment Successful</h1>
        
        <p class="text-center text-xl text-gray-700">Your payment was successful!</p>
        <p class="text-center text-lg text-gray-600 mt-4">
            Your order has been completed, and the payment has been processed successfully.
        </p>

        <div class="text-center mt-6">
            <a href="{{ route('bulk.orders.index') }}" class="text-blue-600 hover:text-blue-800">
                Back to Bulk Orders
            </a>
        </div>
    </div>
@endsection