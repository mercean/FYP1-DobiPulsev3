@extends('layouts.master')

@section('content')
<div class="flex flex-col lg:flex-row min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('components.regular.sidebar')


    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">🛍️ Redemption Catalog</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rewards as $item)
                <div class="flex flex-col items-center text-center bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-xl transition duration-300 min-w-[220px]">
                    <div class="text-4xl mb-3">{{ $item->icon }}</div>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $item->title }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Requires <strong>{{ $item->points_required }} pts</strong>
                    </p>

                    <form method="POST" action="{{ route('redeem.generate', $item->id) }}" class="w-full mt-auto">
                        @csrf
                        <button 
                            class="mt-4 w-full px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition {{ $points < $item->points_required ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $points < $item->points_required ? 'disabled' : '' }}>
                            Redeem
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-10 text-center text-sm text-gray-600 dark:text-gray-400">
            📲 Scan the QR code on any laundry machine to earn more points for redemption.
        </div>
    </div>
</div>
@endsection
