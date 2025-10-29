{{-- Signup Template (User) --}}
<x-layouts.app :title="'Sign Up'">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            {{-- Header --}}
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl mb-6">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Create your account</h2>
                <p class="text-sm text-gray-600">Sign up to get started</p>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-2xl sm:rounded-2xl border border-gray-100">
                {{-- Alert Messages --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
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

                {{-- Register Form (demo only, posts to login to reuse demo flow) --}}
                <form class="space-y-6" action="{{ route('login.attempt') }}" method="POST">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}"
                            class="block w-full pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="Your full name" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="you@example.com" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="block w-full pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="Create a password" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="block w-full pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="Confirm your password" />
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Register
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm">
                    <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-500">Already have an account? Sign in</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
