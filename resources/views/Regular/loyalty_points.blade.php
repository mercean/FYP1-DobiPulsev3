@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition duration-300">
    
    <!-- Sidebar -->
    @include('components.regular.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-8">⭐ My Loyalty Points</h1>

        <!-- Points Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
            <h2 class="text-xl font-semibold mb-2">🎯 Current Points</h2>
            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $points }} pts</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Earn more points by completing orders and redeem for rewards.</p>
        </div>

        <!-- Coupons Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
            <h2 class="text-xl font-semibold mb-4">🎟️ My Coupons</h2>

            @if ($coupons->isEmpty())
                <p class="text-sm text-gray-600 dark:text-gray-400">You have not redeemed any coupons yet.</p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($coupons as $coupon)
                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 shadow">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Coupon Code</p>
                            <p class="text-xl font-bold text-blue-700 dark:text-blue-400 mb-2">{{ $coupon->code }}</p>
                            <p class="text-sm mb-1">Type: <span class="capitalize">{{ $coupon->type }}</span></p>
                            <p class="text-sm">
                                Value: 
                                @if ($coupon->type === 'percent')
                                    {{ $coupon->value }}%
                                @elseif($coupon->type === 'fixed')
                                    RM{{ $coupon->value }}
                                @else
                                    {{ $coupon->value }}
                                @endif
                            </p>
                            <p class="mt-2 text-xs font-semibold text-{{ $coupon->used ? 'red-500' : 'green-500' }}">
                                {{ $coupon->used ? 'Used' : 'Unused' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Redeem Catalog Redirect -->
        <div class="text-center">
            <a href="{{ route('redeem_catalog') }}" 
               class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                🎁 View Redeem Catalog
            </a>
        </div>
    </main>
</div>
@endsection
