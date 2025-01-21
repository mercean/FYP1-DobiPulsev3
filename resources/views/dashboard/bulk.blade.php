@extends('layouts.master')

@section('content')
    <div class="bulk-dashboard-container container mx-auto p-6">
        <!-- Welcome Section -->
        <div class="welcome-section text-center mb-8">
            <h1 class="text-4xl font-semibold text-white">Welcome, {{ Auth::user()->name }}!</h1>
            <p class="text-lg text-gray-200">You're on the Bulk User Dashboard</p>
        </div>

        <!-- Dashboard content layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Account Section -->
            <div class="bulk-dashboard-card bulk-dashboard-account-section">
                <h2 class="account-section-title text-white">Account</h2>
                <ul class="account-links">
                    <li>
                        <a href="{{ route('bulk.orders.index') }}" class="account-link">Check Bulk Orders</a>
                    </li>
                    <li>
                        <a href="{{ route('edit.profile') }}" class="account-link">Edit My Profile</a>
                    </li>
                </ul>
            </div>

            <!-- Profile Section -->
            <div class="bulk-dashboard-card bulk-dashboard-profile-section col-span-2">
                <h2 class="text-xl font-semibold text-white mb-4">My Profile</h2>
                <div class="space-y-2">
                    <p class="text-gray-200"><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p class="text-gray-200"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('edit.profile') }}" class="text-gray-200 hover:text-gray-400 underline">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div class="bulk-dashboard-action-button-container mt-6">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex justify-center items-center">
                <a href="{{ route('bulk.orders.create') }}" class="bulk-dashboard-action-button">
                    Request New Bulk Order
                </a>
            </div>
        </div>
    </div>
@endsection
