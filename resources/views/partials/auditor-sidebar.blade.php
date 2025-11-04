{{-- Auditor Sidebar --}}

<aside class="w-64 bg-white rounded-2xl shadow-sm ring-1 ring-black/5 h-fit sticky top-6">
    <div class="p-6">
        <nav class="space-y-1">
            <a href="{{ route('auditor.dashboard') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('auditor.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('auditor.status.guide') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('auditor.status.guide') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9" />
                </svg>
                Status Guide
            </a>

            <div class="border-t border-gray-200 my-4"></div>

            <a href="{{ route('auditor.profile.show') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('auditor.profile.show') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Profile
            </a>

            <a href="{{ route('logout') }}"
               class="flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                Logout
            </a>
        </nav>
    </div>
</aside>
