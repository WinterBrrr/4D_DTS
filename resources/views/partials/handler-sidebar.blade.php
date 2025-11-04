{{-- Handler Sidebar --}}
<aside class="w-64 bg-white rounded-3xl shadow-sm p-6 flex flex-col gap-6">
    <nav class="flex flex-col gap-2">
        <a href="{{ route('handler.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-emerald-700 font-semibold bg-emerald-50 hover:bg-emerald-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" /></svg>
            Dashboard
        </a>
        <a href="{{ route('upload') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm4 4h8v8H8V8z" /></svg>
            Upload Document
        </a>
        <a href="{{ route('status.guide') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9" /></svg>
            Status Guide
        </a>
        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Profile
        </a>
        <a href="{{ route('logout') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-red-700 hover:bg-red-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" /></svg>
            Logout
        </a>
    </nav>
</aside>
