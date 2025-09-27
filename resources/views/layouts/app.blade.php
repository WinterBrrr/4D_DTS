<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'App' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-gray-50 text-gray-900 antialiased">
        <div class="min-h-dvh flex flex-col">
            <header class="border-b bg-white">
                <div class="mx-auto w-full max-w-7xl px-4 py-4 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="font-semibold">DTS</a>
                    @if(session('logged_in'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-white text-sm hover:bg-black/90">Log out</button>
                        </form>
                    @endif
                </div>
            </header>
            <main class="flex-1">
                {{ $slot }}
            </main>
            <footer class="border-t bg-white">
                <div class="mx-auto w-full max-w-7xl px-4 py-6 text-sm text-gray-500">© {{ date('Y') }} DTS</div>
            </footer>
        </div>
    </body>
    </html>


