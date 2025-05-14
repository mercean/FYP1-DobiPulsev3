@extends('layouts.master')

@section('content')
<div class="flex justify-center min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <div class="w-full max-w-2xl p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-10">

        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-white">🧺 Create Bulk Order</h1>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Bulk Order Form -->
        <form action="{{ route('bulk.orders.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Cloth Type -->
            <div>
                <label for="cloth_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cloth Type</label>
                <input type="text" name="cloth_type" id="cloth_type" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Load (kg) -->
            <div>
                <label for="load_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Load (kg)</label>
                <input type="number" name="load_kg" id="load_kg" step="0.1" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Load Arrival Date -->
            <div>
                <label for="load_arrival_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Load Arrival Date</label>
                <input type="date" name="load_arrival_date" id="load_arrival_date" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Load Arrival Time -->
            <div>
                <label for="load_arrival_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Load Arrival Time</label>
                <input type="time" name="load_arrival_time" id="load_arrival_time" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Pickup Date -->
            <div>
                <label for="pickup_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Date</label>
                <input type="date" name="pickup_date" id="pickup_date" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Pickup Time -->
            <div>
                <label for="pickup_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Time</label>
                <input type="time" name="pickup_time" id="pickup_time" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                    📤 Submit Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
