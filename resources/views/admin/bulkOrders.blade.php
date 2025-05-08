@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center mb-6">Bulk Orders</h1>

        <!-- Filter dropdown for statuses -->
        <form method="GET" action="{{ route('admin.bulkOrders') }}">
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                </select>
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </div>
        </form>

        <!-- Bulk Orders Table -->
        <table class="admin-dashboard-table">
            <thead>
                <tr class="admin-dashboard-table-header">
                    <th class="admin-dashboard-table-cell">Order ID</th>
                    <th class="admin-dashboard-table-cell">User Name</th>
                    <th class="admin-dashboard-table-cell">Status</th>
                    <th class="admin-dashboard-table-cell">Price</th>
                    <th class="admin-dashboard-table-cell">Action</th>
                    <th class="admin-dashboard-table-cell">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bulkOrders as $bulkOrder)
                    <tr>
                        <td class="admin-dashboard-table-cell">{{ $bulkOrder->id }}</td>
                        <td class="admin-dashboard-table-cell">{{ $bulkOrder->user->name }}</td>
                        <td class="admin-dashboard-table-cell">{{ $bulkOrder->status }}</td>
                        <td class="admin-dashboard-table-cell">${{ number_format($bulkOrder->price, 2) }}</td>
                        <td class="admin-dashboard-table-cell">
                            <!-- Add action buttons for update -->
                            <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $bulkOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $bulkOrder->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="processing" {{ $bulkOrder->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="finished" {{ $bulkOrder->status == 'finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                                <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                            </form>
                        </td>
                        <td class="admin-dashboard-table-cell">
                            <a href="{{ route('admin.viewBulkOrderDetails', $bulkOrder->id) }}" class="btn btn-info">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
