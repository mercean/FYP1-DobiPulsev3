@extends('layouts.master')

@section('content')
    <div class="bulk-order-container container mx-auto p-6">
        <!-- Title Section -->
        <h1 class="bulk-order-title text-center text-4xl font-semibold text-gray-800 mb-8">Bulk Orders</h1>

        <!-- Display the personalized greeting -->
        <div class="greeting-section text-center mb-8">
            <h2 class="text-xl font-semibold text-gray-700">
                Hello, {{ Auth::user()->name }}! You have placed {{ $orderCount }} orders.
            </h2>
        </div>

        <!-- Button to Create New Bulk Order -->
        <div class="bulk-order-section text-center custom-gap mb-8">
            <a href="{{ route('bulk.orders.create') }}" class="btn-create">
                Create New Bulk Order
            </a>
        </div>

        <!-- Bulk Orders Table -->
        <div class="bulk-order-table-container overflow-x-auto">
            <table class="bulk-order-table w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left">Cloth Type</th>
                        <th class="px-6 py-3 text-left">Weight (kg)</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-100">
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
                            <td class="px-6 py-4">
                                <a href="{{ route('bulk.orders.edit', $order->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a> |
                                <form action="{{ route('bulk.orders.destroy', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>

                                <!-- Pay Now button shown if status = approved and price > 0 -->
                                @if($order->status === 'approved' && $order->price > 0)
                                    <button type="button" class="pay-now-btn text-green-600 hover:text-green-800" data-order-id="{{ $order->id }}">
                                        Pay Now
                                    </button>
                                @elseif($order->status === 'completed')
                                    <span class="ml-3 text-gray-500">Paid</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Card Input Field -->
        <div id="card-element" class="mt-4" style="height: 50px; border: 1px solid #ccc; padding: 10px;">
            <!-- Stripe Elements Card Input will appear here -->
        </div> <!-- Stripe Elements Card Input -->
        <div id="card-errors" role="alert"></div> <!-- Error Message -->

    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Stripe Public Key
            const stripe = Stripe('pk_test_51QgC8rHYRwWWkzfTLPk4evMfgT1qOSq39ecoJMf75h4eG4pjuyJab6Yi8V6QdPRMtPAYb8N5R890WWzaoUEaNNdj009DAkAKoD'); // Your Stripe Publishable Key

            // Create an instance of Elements
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element'); // Mount the card element

            document.querySelectorAll('.pay-now-btn').forEach(button => {
                button.addEventListener('click', async (e) => {
                    e.preventDefault();  // Prevent form submission
                    const orderId = e.target.getAttribute('data-order-id');

                    if (!orderId) {
                        console.error("No order ID found for this button.");
                        return; // Prevent execution if no order ID is found
                    }

                    console.log("Pay Now button clicked for Order ID:", orderId); // Debug log

                    // Fetch client secret from backend
                    const response = await fetch('{{ route('payment.bulk.initiate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ order_id: orderId })
                    });

                    const data = await response.json();
                    console.log("Client Secret Response:", data); // Debug log

                    if (data.clientSecret) {
                        // Confirm the payment with Stripe
                        const result = await stripe.confirmCardPayment(data.clientSecret, {
                            payment_method: {
                                card: cardElement,
                            }
                        });

                        if (result.error) {
                            alert("Payment failed: " + result.error.message);
                        } else if (result.paymentIntent.status === 'succeeded') {
                            window.location.href = "{{ route('payment.success') }}?order_id=" + orderId;
                        }
                    } else {
                        console.log("Client secret not received.");
                        alert('Error fetching client secret.');
                    }
                });
            });
        });
    </script>
    @endsection
@endsection
