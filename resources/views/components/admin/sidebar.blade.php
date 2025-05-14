<aside
    class="fixed top-0 left-0 h-full w-64 bg-[#0f172a] text-white shadow-xl transform transition-transform duration-300 z-50"
    :class="{ 'translate-x-0': showSidebar, '-translate-x-full': !showSidebar }"
    x-show="showSidebar"
    @click.away="showSidebar = false"
    x-cloak>
    
    <div class="flex justify-between items-center px-6 py-4 border-b border-white/20">
        <h2 class="text-lg font-bold">Menu</h2>
        <button @click="showSidebar = false" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="p-6 space-y-4 text-sm font-medium">
        <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Dashboard</a>
        <a href="{{ route('regular.orders') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">My Orders</a>
        <a href="/redeem_catalog" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Redemption Catalog</a>
        <a href="/notifications" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Notifications</a>
        <a href="/settings" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Settings</a>
        <a href="/loyalty" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Loyalty Points</a>
    </nav>
</aside>
