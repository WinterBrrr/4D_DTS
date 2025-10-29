{{-- User Sidebar: Home, Create Document, Logout --}}
<aside class="hidden md:flex flex-col justify-between w-24 rounded-2xl bg-gradient-to-b from-emerald-500 to-teal-600 text-white py-6 px-3 shadow-sm">
    <div class="rounded-2xl bg-white/10 p-3 flex flex-col items-center gap-3">
        {{-- Avatar removed per request --}}
        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="group h-12 w-12 grid place-items-center rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white text-emerald-600' : 'bg-white/10 hover:bg-white/20' }} transition" title="Home">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
            </svg>
        </a>

        {{-- Create Document --}}
        <a href="{{ route('upload') }}" class="group h-12 w-12 grid place-items-center rounded-xl {{ request()->routeIs('upload') ? 'bg-white text-emerald-600' : 'bg-white/10 hover:bg-white/20' }} transition" title="Create Document">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>

    {{-- Bottom: Logout --}}
    <div class="grid place-items-center gap-3">
        <div class="w-full h-px bg-white/30"></div>
        <a href="{{ url('/logout') }}" class="h-12 w-12 grid place-items-center rounded-xl bg-white/10 hover:bg-white/20 transition" title="Logout">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </a>
    </div>
</aside>
