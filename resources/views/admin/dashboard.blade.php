@extends('layouts.master')

@section('content')
    <div class="admin-dashboard-container container mx-auto p-6">

        <!-- Overview Section -->
        <div class="grid-container mb-6">

            <!-- Total Users Card -->
            <div class="admin-dashboard-card admin-dashboard-total-users">
                <h3 class="admin-dashboard-card-title">Total Users</h3>
                <p class="admin-dashboard-card-value">{{ $totalUsers }}</p>
            </div>

            <!-- Removed the total-orders card previously here -->

            <!-- Total Bulk Orders Card -->
            <div class="admin-dashboard-card admin-dashboard-total-bulk-orders">
                <h3 class="admin-dashboard-card-title">Total Bulk Orders</h3>
                <p class="admin-dashboard-card-value">{{ $totalBulkOrders }}</p>
            </div>

        </div>

        <!-- Orders List Table -->
        <div class="admin-dashboard-admin-card">
            <h2 class="admin-dashboard-section-title">Order List</h2>

            <!-- Regular Orders Table -->
            <h3 class="section-sub-title">Regular Orders</h3>
            <table class="admin-dashboard-table">
                <thead>
                    <tr class="admin-dashboard-table-header">
                        <th class="admin-dashboard-table-cell">Order ID</th>
                        <th class="admin-dashboard-table-cell">Status</th>
                        <th class="admin-dashboard-table-cell">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="admin-dashboard-table-cell">{{ $order->id }}</td>
                            <td class="admin-dashboard-table-cell">{{ $order->status }}</td>
                            <td class="admin-dashboard-table-cell">
                                @if($order->status === 'Pending')
                                    <form action="{{ route('admin.updateOrderStatus', ['id' => $order->id, 'type' => 'order']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.updateOrderStatus', ['id' => $order->id, 'type' => 'order']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                @else
                                    <p>Status cannot be changed.</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Bulk Orders Table -->
            <h3 class="section-sub-title">Bulk Orders</h3>
            <table class="admin-dashboard-table">
                <thead>
                    <tr class="admin-dashboard-table-header">
                        <th class="admin-dashboard-table-cell">Order ID</th>
                        <th class="admin-dashboard-table-cell">Status</th>
                        <th class="admin-dashboard-table-cell">Price (if Approved)</th>
                        <th class="admin-dashboard-table-cell">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulkOrders as $bulkOrder)
                        <tr>
                            <td class="admin-dashboard-table-cell">{{ $bulkOrder->id }}</td>
                            <td class="admin-dashboard-table-cell">{{ $bulkOrder->status }}</td>

                            <!-- Price Column -->
                            <td class="admin-dashboard-table-cell">
                                @if($bulkOrder->status === 'approved')
                                    <!-- If status is approved, allow admin to set/update price -->
                                    <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Keep status as approved -->
                                        <input type="hidden" name="status" value="approved">

                                        <label for="price_{{ $bulkOrder->id }}" class="block text-sm font-medium text-gray-700">Price</label>
                                        <input 
                                            type="number" 
                                            step="0.01"
                                            name="price" 
                                            id="price_{{ $bulkOrder->id }}" 
                                            class="form-control" 
                                            value="{{ $bulkOrder->price ?? 0 }}"
                                        />

                                        <button type="submit" class="btn btn-info mt-2">Update Price</button>
                                    </form>
                                @else
                                    @if(isset($bulkOrder->price) && $bulkOrder->price > 0)
                                        ${{ number_format($bulkOrder->price, 2) }}
                                    @else
                                        N/A
                                    @endif
                                @endif
                            </td>

                            <!-- Status Action Column -->
                            <td class="admin-dashboard-table-cell">
                                <form action="{{ route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder']) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label for="status_{{ $bulkOrder->id }}" class="block text-sm font-medium text-gray-700">Select Status</label>
                                    <select name="status" id="status_{{ $bulkOrder->id }}" class="form-select">
                                        <option value="pending"   {{ $bulkOrder->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                                        <option value="approved"  {{ $bulkOrder->status == 'approved'  ? 'selected' : '' }}>Approved</option>
                                        <option value="completed" {{ $bulkOrder->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>

                                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
