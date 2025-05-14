@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
@include('components.bulk.sidebar')


    <!-- Main Content -->
    <main class="flex-1 p-10">
        <!-- Welcome Section -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Welcome, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage your bulk laundry orders efficiently</p>
        </div>

        <!-- Bulk Order Summary Cards -->
@php
    $totalBulkOrders = $orders->total();
    $pendingBulkOrders = $orders->filter(fn($order) => $order->status === 'pending')->count();
    $totalBulkWeight = $orders->sum('load_kg');
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Bulk Orders (All Pages)</h3>
        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $totalBulkOrders }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Pending (This Page)</h3>
        <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400 mt-2">{{ $pendingBulkOrders }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center">
        <h3 class="text-sm text-gray-500 dark:text-gray-400">Total Weight (This Page)</h3>
        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">{{ number_format($totalBulkWeight, 1) }} kg</p>
    </div>
</div>



      

        <!-- Bulk Orders List Table -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">📦 Your Bulk Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                        <tr>
                            <th class="px-6 py-3">Cloth Type</th>
                            <th class="px-6 py-3">Weight (kg)</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Price</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">{{ $order->cloth_type }}</td>
                            <td class="px-6 py-4">{{ $order->load_kg }}</td>
                            <td class="px-6 py-4">{{ ucfirst($order->status) }}</td>
                            <td class="px-6 py-4">
                                @if($order->price && $order->price > 0)
                                    ${{ number_format($order->price, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('bulk.orders.edit', $order->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form action="{{ route('bulk.orders.destroy', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                                @if($order->status === 'PayNow' && $order->price > 0)
                                    <a href="{{ route('payment.bulk.gateway', $order->id) }}" class="text-green-600 hover:underline">Pay Now</a>
                                @elseif($order->status === 'Paid')
                                    <span class="ml-2 text-gray-400">Paid</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection