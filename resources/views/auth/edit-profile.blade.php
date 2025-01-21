@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-center mb-6">Edit Profile</h1>

        <form action="{{ route('update.profile') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control w-full p-2 border border-gray-300 rounded-md" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="form-control w-full p-2 border border-gray-300 rounded-md" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control w-full p-2 border border-gray-300 rounded-md" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="text-white bg-blue-600 px-6 py-3 rounded-lg hover:bg-blue-700">Update Profile</button>
                </div>
            </div>
        </form>
    </div>
@endsection
