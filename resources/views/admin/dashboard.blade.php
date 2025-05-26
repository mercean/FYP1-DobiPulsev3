@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Welcome Section -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white">👋 Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">Here's your admin control panel overview.</p>
    </div>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">👥 Total Users</h2>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">📦 Bulk Orders</h2>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $totalBulkOrders }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">🧺 Normal Orders</h2>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- 📈 Chart Section -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-10">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">📉 Trends and Distribution</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <canvas id="lineChart" height="200"></canvas>
            </div>
            <div>
                <canvas id="horizontalBarChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Order Analysis -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-10">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">📊 Order Analysis</h2>
        <ul class="mb-4 list-disc list-inside text-gray-700 dark:text-gray-300">
            @foreach ($statusDistribution as $status)
                <li><strong>{{ ucfirst($status->status) }}:</strong> {{ $status->count }} orders</li>
            @endforeach
        </ul>
        <p class="text-gray-700 dark:text-gray-300 mb-2">✅ Completion Rate: <strong>{{ round($orderCompletionRate, 2) }}%</strong></p>
        <p class="text-gray-700 dark:text-gray-300">⏱️ Avg. Completion Time: <strong>{{ round($avgTimeToCompleteOrders, 2) }} minutes</strong></p>
    </div>

    <!-- Normal Orders Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-10">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">🧾 Normal Orders</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    @foreach ($orders as $order)
                    <tr>
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2">RM{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Order Management -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">📝 Bulk Order Management</h2>
            <form action="{{ route('admin.bulkOrders') }}" method="GET">
                <select name="status" class="rounded-lg px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                </select>
                <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Action</th>
                        <th class="px-4 py-2">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    @foreach ($bulkOrders as $bulkOrder)
                    <tr>
                        <td class="px-4 py-2">{{ $bulkOrder->id }}</td>
                        <td class="px-4 py-2">{{ $bulkOrder->user->name }}</td>
                        <td class="px-4 py-2">{{ $bulkOrder->status }}</td>
                        <td class="px-4 py-2">
                            @if($bulkOrder->status === 'approved' && $bulkOrder->price <= 0)
                            <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <input type="number" step="0.01" name="price" class="rounded px-2 py-1 text-sm" required>
                                <button class="ml-2 bg-indigo-600 text-white px-2 py-1 rounded">Update</button>
                            </form>
                            @elseif($bulkOrder->price > 0)
                                RM{{ number_format($bulkOrder->price, 2) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="status" class="rounded px-2 py-1">
                                    <option value="pending" {{ $bulkOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $bulkOrder->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="PayNow" {{ $bulkOrder->status == 'PayNow' ? 'selected' : '' }}>Pay Now</option>
                                    <option value="paid" {{ $bulkOrder->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="processing" {{ $bulkOrder->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="waiting pickup" {{ $bulkOrder->status == 'waiting pickup' ? 'selected' : '' }}>Waiting Pickup</option>
                                    <option value="finished" {{ $bulkOrder->status == 'finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                                <button class="ml-2 bg-blue-600 text-white px-2 py-1 rounded">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.viewBulkOrderDetails', $bulkOrder->id) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- User Management Board -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">👤 User Management</h2>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2">User ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-gray-700">
                @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-2">{{ $user->id }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ ucfirst($user->account_type) }}</td>
                    <td class="px-4 py-2">
                        @if ($user->account_type !== 'admin')
                        <form action="{{ route('admin.createForm') }}" method="GET">
                            @csrf
                            <button class="bg-green-600 text-white px-3 py-1 rounded">Make Admin</button>
                        </form>
                        @else
                        <span class="text-gray-500">Admin</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.createForm') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Create New Admin</a>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   // After including Chart.js (already included in master layout:contentReference[oaicite:5]{index=5})
const lineCtx = document.getElementById('lineChart');
if (lineCtx) {
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels) !!},      // e.g. ["Mon","Tue",...]
            datasets: [{
                label: 'Machines Used per Day',
                data: {!! json_encode($dailyCounts) !!},    // e.g. [5, 8, 3, ...] orders per day
                borderColor: 'rgba(54, 162, 235, 1)',       // blue line for clarity
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // translucent fill
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { 
              y: { beginAtZero: true, stepSize: 1, max: 12 }  // y-axis from 0 to 12+ (12 machines)
            }
        }
    });
}


    const barCtx = document.getElementById('horizontalBarChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Bulk Orders', 'Normal Orders'],
                datasets: [{
                    label: 'Orders',
                    data: [{{ $totalBulkOrders }}, {{ $totalOrders }}],
                    backgroundColor: ['#10B981', '#8B5CF6']
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
        });
    }
</script>
@endpush
