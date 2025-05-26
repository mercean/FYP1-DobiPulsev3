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

                <!-- Points Activity History -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-10">
            <h2 class="text-xl font-semibold mb-4">📜 Points Activity</h2>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @forelse($loyaltyLogs as $entry)
                    <li class="py-2 flex justify-between">
                        <span>
                        <!-- Indicate Earn or Redeem -->
                        @if($entry->points > 0)
                            Earned <strong>{{ $entry->points }}</strong> points 
                        @else 
                            Redeemed <strong>{{ abs($entry->points) }}</strong> points 
                        @endif 
                        on {{ $entry->created_at->format('d M Y') }}
                        <!-- If earned, show expiration -->
                        @if($entry->points > 0)
                            <em class="text-gray-500"> (expires {{ \Carbon\Carbon::parse($entry->expiry_date)->format('d M Y') }})</em>
                        @endif
                        </span>
                    </li>
                @empty
                    <li class="py-2 text-gray-600 dark:text-gray-400">No loyalty point activity yet.</li>
                @endforelse
                @foreach($redemptions as $redeem)
                    <li class="py-2 flex justify-between">
                        <span>Redeemed <strong>{{ $redeem['points'] }}</strong> points on {{ $redeem['date']->format('d M Y') }} 
                        <em class="text-gray-500">({{ $redeem['title'] }})</em>
                        </span>
                        <span class="text-xs text-gray-500">Coupon Code: {{ $redeem['code'] }}</span>
                    </li>
                @endforeach
            </ul>
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
