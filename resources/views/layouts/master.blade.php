<!DOCTYPE html>
<html lang="en"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', open: false }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }"
      x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DobiPulse</title>

    <!-- Tailwind + Alpine -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen transition-colors duration-300">

    <!-- Navbar -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800 dark:text-white">DobiPulse</a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex space-x-6 items-center">
                <a href="{{ url('/') }}" class="hover:underline">Home</a>
                <a href="{{ route('services') }}" class="hover:underline">Services</a>
                <a href="{{ route('edit.profile') }}" class="hover:underline">My Account</a>
                <a href="{{ route('about') }}" class="hover:underline">About Us</a>

                @guest
                    <a href="{{ url('register') }}" class="hover:underline">Register</a>
                    <a href="{{ url('login') }}" class="hover:underline">Login</a>
                @endguest

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline text-sm">Logout</button>
                    </form>
                @endauth

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="ml-4 px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-sm">
                    <span x-text="darkMode ? '☀ Light' : '🌙 Dark'"></span>
                </button>
            </nav>

            <!-- Mobile Menu Toggle -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-700 dark:text-gray-200 focus:outline-none">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition class="md:hidden bg-white dark:bg-gray-800 px-6 pb-4 space-y-2">
            <a href="{{ url('/') }}" class="block hover:underline">Home</a>
            <a href="{{ route('services') }}" class="block hover:underline">Services</a>
            <a href="{{ route('edit.profile') }}" class="block hover:underline">My Account</a>
            <a href="{{ route('about') }}" class="block hover:underline">About Us</a>

            @guest
                <a href="{{ url('register') }}" class="block hover:underline">Register</a>
                <a href="{{ url('login') }}" class="block hover:underline">Login</a>
            @endguest

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left hover:underline">Logout</button>
                </form>
            @endauth

            <button @click="darkMode = !darkMode" class="w-full text-left px-2 py-1 rounded bg-gray-200 dark:bg-gray-700 mt-2">
                <span x-text="darkMode ? '☀ Light Mode' : '🌙 Dark Mode'"></span>
            </button>
        </div>
    </header>

    <!-- Page Content -->
    <main class="container mx-auto px-4 py-6 transition duration-300 bg-gray-300 dark:bg-gray-900 rounded-lg">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm py-6 text-gray-600 dark:text-gray-400">
        &copy; 2025 DobiPulse. All rights reserved.
    </footer>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
