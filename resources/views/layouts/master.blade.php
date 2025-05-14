<!-- MASTER BLADE TEMPLATE (layouts/master.blade.php) -->
<!DOCTYPE html>
<html lang="en"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', showSidebar: window.innerWidth >= 768 }"
      x-init="
        $watch('darkMode', val => localStorage.setItem('darkMode', val));
        window.addEventListener('resize', () => showSidebar = window.innerWidth >= 768);
      "
      :class="{ 'dark': darkMode }"
      x-cloak>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SobiPulse</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-all duration-300 flex">

  <!-- SIDEBAR ROLE CHECK -->
  @auth
    @if (Auth::user()->account_type === 'regular')
      
    @elseif (Auth::user()->account_type === 'bulk')
      @include('components.bulk.sidebar')
    @elseif (Auth::user()->account_type === 'admin')
      @include('components.admin.sidebar')
    @endif
  @endauth

  <!-- Main Content Wrapper -->
<div :class="showSidebar ? 'md:ml-64' : 'md:ml-0'" class="flex-1 flex flex-col transition-all duration-300 min-h-screen">

    <!-- Navbar -->
    <header class="bg-white dark:bg-gray-800 shadow px-4 py-4 flex items-center justify-between md:px-8 sticky top-0 z-30">
      @auth
        <!-- Burger Toggle -->
          <button @click="showSidebar = !showSidebar" class="text-gray-700 dark:text-gray-200">
          <template x-if="!showSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </template>
          <template x-if="showSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </template>
        </button>
      @endauth

      <!-- Top Navigation -->
      <nav class="flex-1 flex justify-end items-center space-x-6">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        <a href="{{ route('services') }}" class="hover:underline">Services</a>
        <a href="{{ route('about') }}" class="hover:underline">About Us</a>

        @guest
          <a href="{{ route('register') }}" class="hover:underline">Register</a>
          <a href="{{ route('login') }}" class="hover:underline">Login</a>
        @endguest

        @auth
          <a href="{{ route('edit.profile') }}" class="hover:underline">My Account</a>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="hover:underline text-sm">Logout</button>
          </form>
        @endauth

        <button @click="darkMode = !darkMode"
                class="ml-4 px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-sm">
          <span x-text="darkMode ? '☀ Light' : '🌙 Dark'"></span>
        </button>
      </nav>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-4 md:p-6">
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm py-6 text-gray-600 dark:text-gray-400">
      &copy; 2025 DobiPulse. All rights reserved.
    </footer>
  </div>
@yield('scripts')

  @stack('scripts')
</body>
</html>
