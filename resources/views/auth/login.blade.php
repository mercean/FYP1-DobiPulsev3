@extends('layouts.master')

@section('content')
<div class="relative min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 overflow-hidden">

    <!-- Background Layer -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/cloth.jpg') }}" alt="Laundry Background" class="w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-br from-white/60 via-white/40 to-white/20 dark:from-black/60 dark:via-black/40 dark:to-black/20 backdrop-blur-sm"></div>
    </div>

    <!-- Login Card -->
    <div class="z-10 w-full max-w-md bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-xl px-8 py-10 backdrop-blur-md animate-fade-in">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">🔐 Welcome Back to DobiPulse</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📧 Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🔒 Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300 transform hover:scale-[1.02]">
                    Login
                </button>
            </div>

            <!-- Register -->
            <div class="text-center text-sm text-gray-600 dark:text-gray-300">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Register here</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out both;
    }
</style>
@endpush
@endsection
