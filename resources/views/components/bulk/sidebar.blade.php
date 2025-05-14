<!-- Sidebar Layout -->
<aside :class="showSidebar ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700 transform transition-transform duration-300 flex flex-col">

    <!-- Header: Avatar + Name -->
    <div class="flex items-center space-x-3 p-4 border-b dark:border-gray-700">
        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=80' }}" 
             class="w-12 h-12 rounded-full border-2 border-blue-500 shadow-sm">
        <div class="flex-1">
            <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Bulk User</p>
        </div>

        <!-- X Button inside sidebar -->
        <button @click="showSidebar = false" class="text-gray-500 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="p-6 space-y-4 text-sm font-medium">
        <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Dashboard</a>
        <a href="{{ route('bulk.orders.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">My Orders</a>
        <a href="{{ route('edit.profile') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Edit Profile</a>
        <a href="{{ route('bulk.orders.create') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-[#0f172a]">Create Order</a>
    </nav>
</aside>


