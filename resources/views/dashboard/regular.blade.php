@extends('layouts.master')

@section('content')
<div x-data="{ showHistory: false }" class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">

    <!-- Sidebar -->
    @include('components.regular.sidebar')

    <!-- Main Dashboard Content -->
    <main class="flex-1 p-6 lg:p-10 space-y-8">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold">👋 Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Here's a quick look at your laundry activity.</p>
            </div>
            <form method="GET" class="text-sm">
                <select name="range" onchange="this.form.submit()" class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 px-3 py-2">
                    <option value="7" {{ request('range') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ request('range') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="all" {{ request('range') == 'all' ? 'selected' : '' }}>All Time</option>
                </select>
            </form>
        </div>

        <!-- Order Prompt (Moved Here) -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-2">
            <p class="text-base font-bold text-gray-700 dark:text-gray-200">🧺 Ready to do laundry? Start ordering!</p>
            <a href="{{ route('orders.create') }}"
               class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-lg transition">
               ➕ Start a New Laundry Order
            </a>
        </div>

        <!-- Chart -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow space-y-4">
            <h2 class="text-lg font-semibold">📈 Order Activity</h2>
            <canvas id="orderChart" height="100"></canvas>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-dashboard.card title="Orders" :value="$orders->count()" />
            <x-dashboard.card title="Total Spent" :value="'RM' . $orders->sum('total_amount')" />
            <x-dashboard.points :points="$points" :max="100" />
        </div>

        <!-- Active Orders Table -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">🔥 Active Orders</h2>

            @php
                 $activeOrders = $orders->filter(fn($o) => in_array($o->status, ['pending', 'processing', 'approved']));
            @endphp
            @if ($activeOrders->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No active orders at the moment.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Machine</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @foreach ($activeOrders as $order)
                                <tr>
                                    <td class="px-4 py-2">{{ $order->id }}</td>
                                    <td class="px-4 py-2">#{{ $order->machine_id }}</td>
                                    <td class="px-4 py-2">{{ $order->required_time }} min</td>
                                    <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                                    <td class="px-4 py-2">
                                    @if ($order->status === 'pending')
                                        <a href="{{ route('payment.regular.page', ['order' => $order->id]) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                            Pay Now
                                        </a>
                                    @elseif ($order->status === 'processing')
                                        <span class="text-green-500 font-medium">In Progress</span>
                                    @elseif ($order->status === 'approved')
                                        <span class="text-blue-500 font-medium">Ready</span>
                                    @endif
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Transaction History Collapsible -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">📋 Transaction History</h2>
                <button @click="showHistory = !showHistory"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 rounded-lg">
                    <span x-text="showHistory ? 'Hide History' : 'Show History'"></span>
                </button>
            </div>

            <div x-show="showHistory" x-transition>
                @if ($orders->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-2">Order ID</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-4 py-2">{{ $order->id }}</td>
                                        <td class="px-4 py-2">RM{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-2">
                                            @if ($order->status === 'pending')
                                                <a href="{{ route('payment.regular.page', ['order' => $order->id]) }}"
                                                   class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Pay Now
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('orderChart');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Order Total (RM)',
                data: chartData.data,
                borderWidth: 1,
                backgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
