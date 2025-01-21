@extends('layouts.master')

@section('content')
    <div class="login-page-container">
        <!-- Title Section -->
        <h1 class="login-page-title">Login</h1>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="login-form-container">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email') }}" required>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="login-submit-btn">
                    Login
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('register') }}" class="login-register-link">Don't have an account? Register here</a>
            </div>
        </form>
    </div>
@endsection
