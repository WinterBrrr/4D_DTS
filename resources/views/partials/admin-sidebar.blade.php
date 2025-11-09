{{-- Admin Sidebar Partial --}}
<div class="w-64 bg-white rounded-2xl shadow-sm ring-1 ring-black/5 h-fit sticky top-6">
    <div class="p-6">
        {{-- Admin Profile Section --}}
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
                @php
                    $userEmail = Session::get('user_email');
                    $userName = Session::get('user_name', 'Admin');
                    $pUser = \App\Models\User::where('email', $userEmail)->first();
                    $profile = $pUser ? \App\Models\UserProfile::where('user_id', $pUser->id)->first() : null;
                    $photo = session('profile_photo_path') ?: ($profile?->profile_photo_path);
                @endphp
                @if($photo)
                    <img src="{{ asset('storage/' . $photo) }}" alt="Profile Image" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-200">
                @else
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-emerald-600">
                            {{ substr($userName, 0, 2) }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ $userName }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>

        {{-- Navigation Menu --}}
        <nav class="space-y-1">

            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v14l-5-3-5 3V5z"/>
                </svg>
                Dashboard
            </a>

            <div>
                <a href="{{ route('admin.pending') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.pending') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pending Documents
                    @php
                        $pendingCount = Session::get('uploaded_documents', []);
                        $pendingCount = count(array_filter($pendingCount, fn($d) => $d['status'] === 'pending'));
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
                <div class="flex items-center pl-10 py-2 text-sm font-medium rounded-lg select-none {{ request()->routeIs('admin.initial') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500' }}">
                    <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Initial Review
                </div>
            </div>

            <div>
                <a href="{{ route('admin.under') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.under') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Under Review
                    @php
                        $reviewingCount = Session::get('uploaded_documents', []);
                        $reviewingCount = count(array_filter($reviewingCount, fn($d) => $d['status'] === 'reviewing'));
                    @endphp
                    @if($reviewingCount > 0)
                        <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $reviewingCount }}
                        </span>
                    @endif
                </a>
                <div class="flex items-center pl-10 py-2 text-sm font-medium rounded-lg select-none {{ request()->routeIs('admin.final') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500' }}">
                    <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Final Processing
                </div>
            </div>

            <a href="{{ route('admin.completed') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.completed') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Completed
                @php
                    $completedCount = Session::get('uploaded_documents', []);
                    $completedCount = count(array_filter($completedCount, fn($d) => $d['status'] === 'completed'));
                @endphp
                @if($completedCount > 0)
                    <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $completedCount }}
                    </span>
                @endif
            </a>

            {{-- Divider --}}
            <div class="border-t border-gray-200 my-4"></div>

            <a href="{{ route('admin.upload') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.upload') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload Document
            </a>

            <a href="{{ route('admin.reports') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Reports
            </a>

            <a href="{{ route('admin.users') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                Users
            </a>

            <a href="{{ route('admin.settings') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-emerald-100 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
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