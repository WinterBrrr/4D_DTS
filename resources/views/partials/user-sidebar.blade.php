{{-- User Sidebar: Home, Create Document, Logout --}}
<script>
    function toggleSidebarMode() {
        const sidebar = document.getElementById('userSidebar');
        sidebar.classList.toggle('sidebar-compact');
    }
</script>
<aside id="userSidebar" class="hidden md:flex flex-col w-64 rounded-2xl bg-white shadow-sm ring-1 ring-black/5 h-fit">
    <div class="p-6">
        {{-- Navigation Menu --}}
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <span class="flex items-center justify-center w-6 h-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                    </svg>
                </span>
                <span class="flex-1">Dashboard</span>
            </a>
            <a href="{{ route('upload') }}" 
               class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('upload') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <span class="flex items-center justify-center w-6 h-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <span class="flex-1">Upload</span>
            </a>
            <a href="{{ route('status.guide') }}" 
               class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('status.guide') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <span class="flex items-center justify-center w-6 h-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m-4-5v9" />
                    </svg>
                </span>
                <span class="flex-1">Status Guide</span>
            </a>
        </nav>
        <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2 w-full px-3 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-50 hover:text-emerald-900 rounded-lg transition-colors">
                <span class="flex items-center justify-center w-6 h-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <span class="flex-1">Profile</span>
            </a>
            <a href="{{ url('/logout') }}" class="flex items-center gap-2 w-full px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                <span class="flex items-center justify-center w-6 h-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </span>
                <span class="flex-1">Logout</span>
            </a>
        </div>
    </div>
</aside>
