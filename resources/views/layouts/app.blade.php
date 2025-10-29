<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    
    {{-- Dynamic Title --}}
    <title>{{ isset($title) ? $title . ' - DTS' : 'Document Tracking System' }}</title>
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ $description ?? 'Document Tracking System - Streamline your document workflow' }}">
    <meta name="keywords" content="document, tracking, workflow, management, system">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    
    {{-- Preload Critical Resources --}}
    <link rel="preload" href="{{ asset('fonts/inter.woff2') }}" as="font" type="font/woff2" crossorigin>
    
    {{-- Styles --}}
    @vite(['resources/css/app.css'])
    
    {{-- Additional Head Content --}}
    @stack('head')
</head>
<body class="min-h-screen bg-slate-50 text-gray-900 antialiased selection:bg-emerald-100 selection:text-emerald-900">
    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm hidden">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
            <p class="mt-2 text-sm text-gray-600">Loading...</p>
        </div>
    </div>

    <div class="min-h-screen flex flex-col">
        {{-- Header --}}
        <header class="sticky top-0 z-40 border-b bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/85 shadow-sm">
            <div class="mx-auto w-full max-w-[1400px] px-4 py-3">
                <div class="flex items-center justify-between">
                    {{-- Logo/Brand --}}
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 font-bold text-lg tracking-tight text-gray-900 hover:text-emerald-600 transition-colors">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>DTS</span>
                        </a>
                        
                        {{-- Breadcrumb Navigation --}}
                        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                            <nav class="hidden md:flex" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-2 text-sm">
                                    @foreach($breadcrumbs as $key => $breadcrumb)
                                        <li class="flex items-center">
                                            @if(!$loop->first)
                                                <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            @if($loop->last)
                                                <span class="text-gray-500 font-medium">{{ $breadcrumb['title'] }}</span>
                                            @else
                                                <a href="{{ $breadcrumb['url'] }}" class="text-gray-600 hover:text-emerald-600 transition-colors">
                                                    {{ $breadcrumb['title'] }}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                        @endif
                    </div>

                    {{-- Right Side Navigation --}}
                    <div class="flex items-center space-x-4">
                        @auth
                            {{-- Notifications --}}
                            <div class="relative">
                                <button type="button" class="relative rounded-full bg-white p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                                    <span class="sr-only">View notifications</span>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h11a1 1 0 001-1V8a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1z"/>
                                    </svg>
                                    {{-- Notification Badge --}}
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                                </button>
                            </div>

                            {{-- User Profile Dropdown --}}
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center space-x-2 rounded-full bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                                    <div class="h-6 w-6 rounded-full bg-emerald-600 flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="hidden sm:block">{{ auth()->user()->name ?? 'User' }}</span>
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                {{-- Dropdown Menu --}}
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    
                                    <div class="px-4 py-2 border-b">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                                    </div>

                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Your Profile
                                        </div>
                                    </a>

                                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Settings
                                        </div>
                                    </a>

                                    <div class="border-t">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <div class="flex items-center">
                                                    <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                    </svg>
                                                    Sign Out
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Guest Navigation --}}
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-600 transition-colors">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                                    Get Started
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error') || session('warning') || session('info'))
            <div class="relative z-30">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex justify-between">
                            <div class="flex">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button @click="show = false" class="text-green-500 hover:text-green-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 p-4" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex justify-between">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                            <button @click="show = false" class="text-red-500 hover:text-red-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Main Content --}}
        <main class="flex-1 relative">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t bg-white mt-auto">
            <div class="mx-auto w-full max-w-[1400px] px-4 py-6">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>© {{ date('Y') }} 4DOCS DOCUMENT TRACKING SYSTEM</span>
                        <span class="hidden sm:inline">•</span>
                        <span class="text-xs">v1.0.0</span>
                    </div>
                    
                    <div class="flex items-center space-x-6 mt-4 sm:mt-0">
                        <a href="{{ route('privacy') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                            Privacy Policy
                        </a>
                        <a href="{{ route('terms') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                            Terms of Service
                        </a>
                        <a href="{{ route('support') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                            Support
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Scripts --}}
    @vite(['resources/js/app.js'])
    
    {{-- Additional Scripts --}}
    @stack('scripts')

    <script>
        // Global JavaScript utilities
        window.showLoading = function() {
            document.getElementById('loading-overlay').classList.remove('hidden');
        };

        window.hideLoading = function() {
            document.getElementById('loading-overlay').classList.add('hidden');
        };

        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const flashMessages = document.querySelectorAll('[x-data*="show: true"]');
                flashMessages.forEach(function(message) {
                    if (message.__x && message.__x.$data) {
                        message.__x.$data.show = false;
                    }
                });
            }, 5000);
        });

        // CSRF token setup for AJAX requests
        window.csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</body>
</html>
