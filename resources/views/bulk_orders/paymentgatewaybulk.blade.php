@extends('layouts.master')

@section('content')
    <div class="payment-gateway-page">
        <div class="payment-gateway-container container mx-auto p-6">
            <h1 class="text-center text-4xl font-semibold text-gray-800 mb-8">Payment Gateway</h1>

            <div class="text-center mb-8">
                <h2 class="text-xl font-semibold text-gray-700">
                    Ready to pay for your order #{{ $order->id }}? Total amount: ${{ number_format($order->price, 2) }}
                </h2>
            </div>

            <!-- Card Input Section -->
            <div id="card-element" class="mt-4" style="height: 50px; border: 1px solid #ccc; padding: 10px;">
                <!-- Stripe Elements Card Input will appear here -->
            </div>
            <div id="card-errors" role="alert"></div> <!-- Error Message -->

            <!-- Payment Action Section -->
            <div class="text-center mt-8">
                <button type="button" id="pay-now-btn" class="pay-now-btn text-green-600 hover:text-green-800">
                    Pay Now
                </button>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stripe = Stripe('pk_test_51QgC8rHYRwWWkzfTLPk4evMfgT1qOSq39ecoJMf75h4eG4pjuyJab6Yi8V6QdPRMtPAYb8N5R890WWzaoUEaNNdj009DAkAKoD'); // Your Stripe Publishable Key

            // Create an instance of Elements
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element'); // Mount the card element

            document.getElementById('pay-now-btn').addEventListener('click', async function (e) {
                e.preventDefault();  // Prevent form submission
                const orderId = "{{ $order->id }}"; // Get the order ID from the view

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
                    alert('Error fetching client secret.');
                }
            });
        });
    </script>
    @endsection
@endsection
