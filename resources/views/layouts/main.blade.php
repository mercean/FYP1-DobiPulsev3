@extends('layouts.master')

@section('content')

<!-- Hero Section with Role Selection -->
<section class="bg-gray-100 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12">
        <div class="w-full lg:w-1/2 text-center lg:text-left">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-white leading-tight mb-4">
                Welcome to <span class="text-blue-600">DobiPulse</span>
            </h1>
            <p class="text-xl text-gray-700 dark:text-gray-300 font-medium mb-3">
                A smarter way to manage your laundry — track, earn, and save with every wash.
            </p>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Join the future of self-service laundromats.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('register') }}?type=regular"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                    👤 I’m a Regular Customer
                </a>
                <a href="{{ route('register') }}?type=bulk"
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                    🏢 I’m a Business User
                </a>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                <strong>Regular:</strong> For individuals.<br>
                <strong>Business:</strong> Bulk order pricing, monthly billing, and admin approval.
            </p>
        </div>
        <div class="w-full lg:w-1/2 flex justify-center">
            <img src="{{ asset('images/welcome-image.jpg') }}" alt="DobiPulse Welcome" class="rounded-xl shadow-lg w-full max-w-md">
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="bg-gray-200 dark:bg-gray-800 py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">How DobiPulse Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="text-5xl mb-4">📲</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Scan & Start</h3>
                <p class="text-gray-600 dark:text-gray-300">Scan the QR on our machines to access the platform instantly.</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="text-5xl mb-4">💰</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Earn Rewards</h3>
                <p class="text-gray-600 dark:text-gray-300">Loyalty points are tracked per wash. Redeem them for discounts or free washes.</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="text-5xl mb-4">🔔</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Get Updates</h3>
                <p class="text-gray-600 dark:text-gray-300">Receive real-time notifications about your laundry status directly to your device.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="bg-gray-100 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
        <div class="w-full md:w-1/2">
            <img src="{{ asset('images/mainpagebanner.jpg') }}" alt="About Us" class="rounded-lg shadow-md w-full">
        </div>
        <div class="w-full md:w-1/2 bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Digitally Transforming Laundromats</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
                DobiPulse is inspired by proven models like LaundroMatic and GrabRewards, offering loyalty systems, automated pricing, and smart dashboards in one seamless platform.
            </p>
            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 mb-4">
                <li>📲 Automated QR-based service access</li>
                <li>🏅 Customer rewards and digital coupons</li>
                <li>📦 Real-time bulk order tracking & weight-based discounts</li>
                <li>📊 Admin dashboard for insights, analytics, and customer engagement</li>
            </ul>
            <p class="font-medium text-gray-800 dark:text-gray-200">
                Built using Laravel, SQL Server, and modern UX/UI principles — DobiPulse is ready for the digital era.
            </p>
        </div>
    </div>
</section>

<!-- Why DobiPulse -->
<section class="bg-blue-50 dark:bg-gray-800 py-20">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Why Choose DobiPulse?</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 max-w-3xl mx-auto">
            We simplify operations for laundromat owners and enhance convenience for customers. Our platform increases retention, drives efficiency, and puts real-time control in your hands.
        </p>
        <a href="{{ route('login') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow transition">
            🚀 Experience It Now
        </a>
    </div>
</section>

<!-- Inside Regular Dashboard -->
<section class="bg-gray-100 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">Inside the Regular Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="text-5xl mb-4">📋</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Order History</h3>
                <p class="text-gray-600 dark:text-gray-300">View past sessions, payment records, and QR machine logs easily.</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="text-5xl mb-4">⭐</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Loyalty Tracker</h3>
                <p class="text-gray-600 dark:text-gray-300">Track your loyalty points and redeem them with a tap — discounts or free washes await.</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="text-5xl mb-4">💳</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Secure Payments</h3>
                <p class="text-gray-600 dark:text-gray-300">Pay using Stripe, e-wallets, or online banking. Fast, secure, and recorded for every transaction.</p>
            </div>
        </div>
    </div>
</section>

@endsection
