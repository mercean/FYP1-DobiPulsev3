@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center mb-6">Transaction History</h1>

        <!-- Button to Export Transaction History to CSV -->
        <div class="text-center mt-4">
            <a href="{{ route('admin.exportTransactionHistory') }}" class="btn btn-success">Export to CSV</a>
        </div>

        <!-- Transaction History Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Order ID</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>${{ number_format($transaction->amount / 100, 2) }}</td> <!-- Convert amount to dollars -->
                            <td>{{ ucfirst($transaction->status) }}</td>
                            <td>
                                @if (isset($transaction->payment_method_details->card))
                                    {{ $transaction->payment_method_details->card->brand }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $transaction->metadata['order_id'] ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($transaction->created)->toDateString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
