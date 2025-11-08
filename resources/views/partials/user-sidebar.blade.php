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
            <div>
                <div class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('user.my-documents') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600' }}">
                    <span class="flex items-center justify-center w-6 h-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m0 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h2" />
                        </svg>
                    </span>
                    <span class="flex-1">My Documents</span>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('user.my-documents', ['tab' => 'sent']) }}"
                       class="flex items-center pl-10 py-2 text-sm font-medium rounded-lg transition-colors {{ (request()->fullUrlIs(route('user.my-documents', ['tab' => 'sent'], false) . '*') || (!request('tab') && request()->routeIs('user.my-documents'))) ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <span class="flex items-center justify-center w-5 h-5 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
                            </svg>
                        </span>
                        Sent
                    </a>
                    <a href="{{ route('user.my-documents', ['tab' => 'received']) }}"
                       class="flex items-center pl-10 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->fullUrlIs(route('user.my-documents', ['tab' => 'received'], false) . '*') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <span class="flex items-center justify-center w-5 h-5 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8m0 0l-4-4m4 4l-4 4" />
                            </svg>
                        </span>
                        Received
                    </a>
                </div>
            </div>
            <a href="{{ route('upload') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('upload') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload Document
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
