{{-- Handler Sidebar --}}
<div class="w-64 bg-white rounded-2xl shadow-sm ring-1 ring-black/5 h-fit sticky top-6">
    <div class="p-6">
        {{-- Handler Profile Section --}}
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-emerald-600">
                        {{ substr(Session::get('user_name', 'Handler'), 0, 2) }}
                    </span>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ Session::get('user_name', 'Handler User') }}</p>
                <p class="text-xs text-gray-500">Handler</p>
            </div>
        </div>

        {{-- Navigation Menu --}}

        <nav class="space-y-1">
            <a href="{{ route('handler.dashboard') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('handler.dashboard') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v14l-5-3-5 3V5z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('handler.pending') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('handler.pending') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pending Documents
            </a>
            <div class="flex items-center pl-10 py-2 text-sm font-medium rounded-lg select-none {{ request()->routeIs('handler.initial') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500' }}">
                <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Initial Review
            </div>

            <a href="{{ route('handler.under') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('handler.under') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Under Review
            </a>
            <div class="flex items-center pl-10 py-2 text-sm font-medium rounded-lg select-none {{ request()->routeIs('handler.final') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500' }}">
                <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Final Processing
            </div>

            <a href="{{ route('handler.completed') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('handler.completed') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Completed
            </a>

            {{-- Divider --}}
            <div class="border-t border-gray-200 my-4"></div>

                <a href="{{ route('upload') }}" 
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('upload') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload Document
            </a>

                <a href="{{ route('status.guide') }}" 
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('status.guide') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9"/>
                </svg>
                Status Guide
            </a>

                <a href="{{ route('profile.show') }}" 
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profile.show') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Profile
            </a>
        </nav>

        {{-- Logout Button --}}
        <div class="mt-6 pt-6 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</div>
