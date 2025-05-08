@extends('layouts.master')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-gray-800 p-6">
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-indigo-600 dark:text-white">Bulk Dashboard</h2>
        </div>
        <nav class="space-y-4">
            <a href="{{ route('bulk.orders.index') }}" class="block text-gray-700 dark:text-gray-300 hover:underline">📦 Check Bulk Orders</a>
            <a href="{{ route('edit.profile') }}" class="block text-gray-700 dark:text-gray-300 hover:underline">✏️ Edit My Profile</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <!-- Welcome Section -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Welcome, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage your bulk laundry orders efficiently</p>
        </div>

        <!-- Profile Summary -->
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📋 My Profile</h2>
                <p class="text-gray-600 dark:text-gray-300"><strong>Name:</strong> {{ Auth::user()->name }}</p>
                <p class="text-gray-600 dark:text-gray-300"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <a href="{{ route('edit.profile') }}" class="inline-block mt-4 text-sm text-indigo-600 hover:underline">Edit Profile</a>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                <h2 class="text-lg font-semibold">🚀 Quick Action</h2>
                <p class="mb-4">Have a new bulk order? Get started now.</p>
                <a href="{{ route('bulk.orders.create') }}" class="bg-white text-purple-700 px-4 py-2 rounded shadow hover:bg-gray-100 text-center">Request New Bulk Order</a>
            </div>
        </div>

        <!-- Optional: Tips or Info Box -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
            <p class="font-bold">💡 Tip:</p>
            <p>Submit bulk orders before 8PM to receive same-day processing!</p>
        </div>
    </main>
</div>
@endsection
