@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-gray-800 p-6">
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-indigo-600 dark:text-white">Bulk Dashboard</h2>
        </div>
        <nav class="space-y-4">
            <a href="{{ route('bulk.orders.index') }}" class="block text-gray-700 dark:text-gray-300 hover:underline">📦 Check Bulk Orders</a>
            <a href="{{ route('edit.profile') }}" class="block text-gray-700 dark:text-gray-300 hover:underline">✏️ Edit My Profile</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <!-- Welcome Section -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Welcome, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage your bulk laundry orders efficiently</p>
        </div>

        <!-- Profile Summary -->
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📋 My Profile</h2>
                <p class="text-gray-600 dark:text-gray-300"><strong>Name:</strong> {{ Auth::user()->name }}</p>
                <p class="text-gray-600 dark:text-gray-300"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <a href="{{ route('edit.profile') }}" class="inline-block mt-4 text-sm text-indigo-600 hover:underline">Edit Profile</a>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                <h2 class="text-lg font-semibold">🚀 Quick Action</h2>
                <p class="mb-4">Have a new bulk order? Get started now.</p>
                <a href="{{ route('bulk.orders.create') }}" class="bg-white text-purple-700 px-4 py-2 rounded shadow hover:bg-gray-100 text-center">Request New Bulk Order</a>
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