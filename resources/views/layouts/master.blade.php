<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DobiPulse</title>

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stripe.js Library (if not included in a specific page) -->
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="master-nav">
        <div class="container">
            <!-- Logo -->
            <div class="text-xl font-semibold logo">
                <a href="{{ url('/') }}" class="text-white">DobiPulse</a>
            </div>

            <!-- Navigation Links -->
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li><a href="{{ route('edit.profile') }}">My Account</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                @guest
                    <li><a href="{{ url('register') }}">Register</a></li>
                    <li><a href="{{ url('login') }}">Login</a></li>
                @endguest
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="logout-button">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        @yield('content')  <!-- This will be where the content of the page will be injected -->
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 DobiPulse. All rights reserved.</p>
    </footer>

    <!-- Include JS files here -->
    @yield('scripts')  <!-- This is where the script section will be injected -->

    <!-- Stripe.js Library -->
    <script src="https://js.stripe.com/v3/"></script>
    
</body>
</html>
