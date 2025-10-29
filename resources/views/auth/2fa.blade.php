<x-layouts.app :title="'Two-Factor Authentication'">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-emerald-100">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Two-Factor Authentication</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter the 6-digit code from your authenticator app
                </p>
            </div>
            
            <form class="mt-8 space-y-6" method="POST" action="{{ route('2fa.verify') }}">
                @csrf
                
                @if($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ $errors->first() }}</h3>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="code" class="sr-only">Authentication Code</label>
                    <input id="code" name="code" type="text" maxlength="6" pattern="[0-9]{6}" 
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 text-center text-2xl tracking-widest focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm" 
                           placeholder="000000" required autofocus>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Verify Code
                    </button>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
