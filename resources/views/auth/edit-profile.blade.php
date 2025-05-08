@extends('layouts.master')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Heading -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">👤 Edit Profile</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Update your personal details here.</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 md:p-10">
        <!-- Avatar Section -->
        <div class="flex items-center space-x-4 mb-8">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128"
                 alt="User Avatar"
                 class="w-20 h-20 rounded-full border-4 border-blue-500 shadow-md">
            <div>
                <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ $user->name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('update.profile') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                <input type="text" id="name" name="name"
                       class="mt-1 w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                <input type="email" id="email" name="email"
                       class="mt-1 w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                <input type="text" id="phone" name="phone"
                       class="mt-1 w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('phone', $user->phone) }}">
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition duration-200">
                    💾 Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
