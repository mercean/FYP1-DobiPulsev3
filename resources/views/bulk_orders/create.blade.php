@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center mb-6">Create Bulk Order</h1>

        <!-- Bulk Order Form -->
        <form action="{{ route('bulk.orders.store') }}" method="POST">
            @csrf

            <!-- Cloth Type Field -->
            <div class="mb-4">
                <label for="cloth_type" class="block text-sm font-medium text-gray-700">Cloth Type</label>
                <input type="text" name="cloth_type" id="cloth_type" class="block w-full px-4 py-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- Load (kg) Field -->
            <div class="mb-4">
                <label for="load_kg" class="block text-sm font-medium text-gray-700">Load (kg)</label>
                <input type="number" name="load_kg" id="load_kg" class="block w-full px-4 py-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- Load Arrival Date Field -->
            <div class="mb-4">
                <label for="load_arrival_date" class="block text-sm font-medium text-gray-700">Load Arrival Date</label>
                <input type="date" name="load_arrival_date" id="load_arrival_date" class="block w-full px-4 py-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- Load Arrival Time Field -->
            <div class="mb-4">
                <label for="load_arrival_time" class="block text-sm font-medium text-gray-700">Load Arrival Time</label>
                <input type="time" name="load_arrival_time" id="load_arrival_time" class="block w-full px-4 py-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- Pickup Date Field -->
            <div class="mb-4">
                <label for="pickup_date" class="block text-sm font-medium text-gray-700">Pickup Date</label>
                <input type="date" name="pickup_date" id="pickup_date" class="block w-full px-4 py-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- Pickup Time Field -->
            <div class="mb-4">
                <label for="pickup_time" class="block text-sm font-medium text-gray-700">Pickup Time</label>
                <input type="time" name="pickup_time" id="pickup_time" class="block w-full px-4 py-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="text-white bg-blue-600 px-6 py-3 rounded-lg hover:bg-blue-700">Submit Order</button>
        </form>
    </div>
@endsection
