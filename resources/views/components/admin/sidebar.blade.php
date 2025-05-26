<aside
    class="fixed top-0 left-0 h-full w-64 bg-[#0f172a] text-white shadow-xl transform transition-transform duration-300 z-50"
    :class="{
        'translate-x-0': showSidebar || sidebarHovered,
        '-translate-x-full': !showSidebar && !sidebarHovered
    }"
    @mouseenter="sidebarHovered = true"
    @mouseleave="sidebarHovered = false"
    x-cloak
>
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b border-white/20">
        <h2 class="text-lg font-bold">Admin Panel</h2>
        <button @click="showSidebar = false" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-6 space-y-4 text-sm font-medium">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-home class="w-5 h-5" /> Dashboard
        </a>

        <a href="{{ route('admin.bulkOrders') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-archive-box class="w-5 h-5" /> Bulk Orders
        </a>

        <a href="{{ route('admin.transactionHistory') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-credit-card class="w-5 h-5" /> Transaction History
        </a>

        <a href="{{ route('promotions.index') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-sparkles class="w-5 h-5" /> Promotions
        </a>

        <a href="{{ route('admin.createForm') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-user-plus class="w-5 h-5" /> Create Admin
        </a>

        <a href="{{ route('notifications.all') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-bell class="w-5 h-5" /> Notifications
        </a>

        <a href="/settings" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
            <x-heroicon-o-cog-6-tooth class="w-5 h-5" /> Settings
        </a>

        <form action="{{ route('logout') }}" method="POST" class="block">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full text-left px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">
                <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" /> Logout
            </button>
        </form>
    </nav>
</aside>
