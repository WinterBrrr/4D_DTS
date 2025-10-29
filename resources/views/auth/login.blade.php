<x-layouts.app :title="'Sign In'">
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    {{-- Left Side - Logo & Branding --}}
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-12 flex flex-col items-center justify-center text-white">
                        <div class="text-center space-y-6">
                            <div class="mx-auto h-48 w-48 bg-white rounded-3xl flex items-center justify-center shadow-2xl transform hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('images/logo.png') }}" alt="4DOCS Logo" class="h-44 w-44">
                            </div>
                            <h1 class="text-5xl font-extrabold tracking-tight">4DOCS</h1>
                            <p class="text-xl font-light text-emerald-50">Document Tracking System</p>
                            <div class="pt-6">
                                <div class="h-1 w-24 bg-white/30 rounded-full mx-auto"></div>
                            </div>
                            <p class="text-emerald-50 text-sm leading-relaxed max-w-sm">
                                Streamline your document workflow with our comprehensive tracking and management solution
                            </p>
                        </div>
                    </div>

                    {{-- Right Side - Login Form --}}
                    <div class="p-12">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                            <p class="text-gray-600">Sign in to your account to continue</p>
                        </div>

                        {{-- Alert Messages --}}
                @if(session('info'))
                    <div class="mb-6 rounded-lg bg-blue-50 p-4 border border-blue-200">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800 font-medium">{{ session('info') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-start">
                                            <span class="inline-block w-1 h-1 bg-red-500 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Login Form --}}
                <form class="space-y-6" action="{{ route('login.attempt') }}" method="POST">
                    @csrf

                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm @error('email') border-red-300 @enderror"
                                placeholder="Enter your email address"
                            />
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm @error('password') border-red-300 @enderror"
                                placeholder="Enter your password"
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePasswordVisibility()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg id="eye-closed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="eye-open" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m-3.122-3.122l-1.415-1.414M12 12l1.415 1.415m0 0L15 15m-1.415-1.415L12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me and Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <label for="remember" class="ml-2 block text-sm text-gray-900 font-medium">
                                Remember me
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors">
                                Forgot your password?
                            </a>
                        </div>
                    </div>

                    {{-- Sign In Button --}}
                    <div>
                        <button
                            type="submit"
                            id="signin-btn"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            <span id="signin-text" class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Sign In to Your Account
                            </span>
                            <span id="loading-text" class="hidden flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Signing you in...
                            </span>
                        </button>
                    </div>
                </form>

                {{-- Divider --}}
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">New to our platform?</span>
                        </div>
                    </div>
                </div>

                {{-- Create Account Button --}}
                <div class="mt-6">
                    <a
                        href="{{ route('register') }}"
                        class="w-full flex justify-center items-center py-3 px-4 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                    >
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Create New Account
                    </a>
                </div>

                {{-- Support Contact --}}
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Need assistance? Contact our support team at
                        <a href="mailto:support@company.com" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors">
                            support@company.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeClosed = document.getElementById('eye-closed');
            const eyeOpen = document.getElementById('eye-open');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeClosed.classList.remove('hidden');
                eyeOpen.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const signinBtn = document.getElementById('signin-btn');
            const signinText = document.getElementById('signin-text');
            const loadingText = document.getElementById('loading-text');

            form.addEventListener('submit', function(e) {
                signinBtn.disabled = true;
                signinText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            });

            // Auto-focus email field
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }
        });
    </script>
</x-layouts.app>