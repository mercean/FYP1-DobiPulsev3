@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">

    <!-- Sidebar -->
    @include('components.regular.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">🧾 My Orders</h1>
        </div>

        <!-- Orders Table -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @if ($orders->isEmpty())
                <p class="text-gray-600 dark:text-gray-300">You have not placed any orders yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-2">{{ $order->order_number }}</td>
                                    <td class="px-4 py-2">RM{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        @if ($order->status === 'pending')
                                            <form method="POST" action="{{ route('orders.destroy', $order->id) }}" onsubmit="return confirm('Cancel this order?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">🗑 Cancel</button>
                                            </form>
                                            <a href="{{ route('payment.regular.page', $order->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">💳 Pay Now</a>
                                        @elseif ($order->status === 'approved')
                                            <span class="text-green-600 dark:text-green-400">✅ Paid</span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 italic">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
