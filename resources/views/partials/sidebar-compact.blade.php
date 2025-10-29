{{-- Compact Icon-only Sidebar: Lock (top), Separator, Home, Clipboard (workflow hub), Bottom Separator, Logout --}}
<aside class="hidden md:flex flex-col justify-between w-24 rounded-2xl bg-gradient-to-b from-emerald-500 to-teal-600 text-white py-6 px-3 shadow-sm">
    <div class="rounded-2xl bg-white/10 p-3 flex flex-col items-center gap-3">
        {{-- Admin shortcut (only visible to admins) --}}
        @if (Session::get('user_role') === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="grid place-items-center h-12 w-12 rounded-xl border border-white/60 bg-white/10 hover:bg-white/20 transition" title="Admin">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V7a4 4 0 10-8 0v4m12 0V7a4 4 0 10-8 0v4m-2 0h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2z" />
            </svg>
        </a>
        @endif

        <div class="my-2 w-full h-px bg-white/30"></div>

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="group h-12 w-12 grid place-items-center rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white text-emerald-600' : 'bg-white/10 hover:bg-white/20' }} transition" title="Home">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
            </svg>
        </a>
        
        {{-- Create Document (user upload) --}}
        <a href="{{ route('upload') }}" class="group h-12 w-12 grid place-items-center rounded-xl {{ request()->routeIs('upload') ? 'bg-white text-emerald-600' : 'bg-white/10 hover:bg-white/20' }} transition" title="Create Document">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>

        {{-- Admin document workflow (only for admins) --}}
        @if (Session::get('user_role') === 'admin')
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button type="button" @click="open = !open"
                    class="group h-12 w-12 grid place-items-center rounded-xl {{ request()->routeIs('admin.pending') || request()->routeIs('admin.initial') || request()->routeIs('admin.under') || request()->routeIs('admin.final') || request()->routeIs('admin.completed') ? 'bg-white text-emerald-600' : 'bg-white/10 hover:bg-white/20' }} transition"
                    title="Documents">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6a2 2 0 012 2v12a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6v2H9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0zm0 0H13" />
                </svg>
            </button>

            <div x-show="open" x-transition
                 class="absolute left-full ml-3 top-0 z-50 w-44 rounded-xl bg-white text-gray-800 shadow-lg ring-1 ring-black/5 py-2">
                <a href="{{ route('admin.pending') }}" class="block px-4 py-2 text-sm hover:bg-emerald-50 {{ request()->routeIs('admin.pending') ? 'text-emerald-700 font-semibold' : '' }}">Pending</a>
                <a href="{{ route('admin.initial') }}" class="block px-4 py-2 text-sm hover:bg-emerald-50 {{ request()->routeIs('admin.initial') ? 'text-emerald-700 font-semibold' : '' }}">Initial Review</a>
                <a href="{{ route('admin.under') }}" class="block px-4 py-2 text-sm hover:bg-emerald-50 {{ request()->routeIs('admin.under') ? 'text-emerald-700 font-semibold' : '' }}">Under Review</a>
                <a href="{{ route('admin.final') }}" class="block px-4 py-2 text-sm hover:bg-emerald-50 {{ request()->routeIs('admin.final') ? 'text-emerald-700 font-semibold' : '' }}">Final Processing</a>
                <a href="{{ route('admin.completed') }}" class="block px-4 py-2 text-sm hover:bg-emerald-50 {{ request()->routeIs('admin.completed') ? 'text-emerald-700 font-semibold' : '' }}">Completing</a>
            </div>
        </div>
        @endif
    </div>

    {{-- Bottom Separator + Logout --}}
    <div class="grid place-items-center gap-3">
        <div class="w-full h-px bg-white/30"></div>
        <a href="{{ url('/logout') }}" class="h-12 w-12 grid place-items-center rounded-xl bg-white/10 hover:bg-white/20 transition" title="Logout">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </a>
    </div>
</aside>
