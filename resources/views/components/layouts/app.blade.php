<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'App' }}</title>
        <script>
            // Force light mode: remove any leftover 'dark' class and stored theme
            try { localStorage.removeItem('theme'); } catch (e) {}
            document.documentElement.classList.remove('dark');
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh antialiased bg-slate-50 text-gray-900">
        <div class="min-h-dvh flex flex-col">
            @if(!request()->is('login'))
            <header class="sticky top-0 z-40 bg-white shadow-sm" style="min-height:48px;">
                <div class="mx-auto w-full max-w-[1400px] px-4 py-2 flex items-center justify-between">
                    @php
                        $role = session('user_role');
                        $dashboardRoute = $role === 'admin' ? route('admin.dashboard') : route('dashboard');
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/logo.png') }}" alt="4DOCS Logo" class="h-12 w-auto">
                        <span class="text-2xl font-bold tracking-tight text-gray-900">4DOCS</span>
                    </a>
                    <div class="flex items-center gap-3"></div>
                </div>
            </header>
            @endif
            <main class="flex-1">
                {{ $slot }}
            </main>
            <footer class="border-t bg-white">
                <div class="mx-auto w-full max-w-[1400px] px-4 py-6 text-sm text-gray-500">
                    © {{ date('Y') }} 4DOCS DOCUMENT TRACKING SYSTEM
                </div>
            </footer>
        </div>
    </body>
    </html>


