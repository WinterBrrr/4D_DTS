@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Two-Factor Authentication Setup'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Two-Factor Authentication</h1>
                    <p class="text-sm text-gray-600">Secure your admin account with TOTP</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Back to Dashboard</a>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- QR Code Setup --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Setup Authenticator App</h2>
                    
                    @if($profile->two_factor_enabled)
                        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-emerald-800 font-medium">2FA is currently enabled</span>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="text-center">
                            <div class="inline-block p-4 bg-white border-2 border-gray-200 rounded-lg">
                                <div id="qr-code" class="w-48 h-48 mx-auto bg-gray-100 rounded flex items-center justify-center">
                                    <span class="text-gray-500 text-sm">QR Code will appear here</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-2">Or enter this code manually:</p>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <code class="text-sm font-mono break-all">{{ $profile->two_factor_secret }}</code>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600">
                            <p class="mb-2"><strong>Instructions:</strong></p>
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Install Google Authenticator or similar TOTP app</li>
                                <li>Scan the QR code or enter the secret manually</li>
                                <li>Enter the 6-digit code below to enable 2FA</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Enable/Disable Form --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        @if($profile->two_factor_enabled)
                            Disable Two-Factor Authentication
                        @else
                            Enable Two-Factor Authentication
                        @endif
                    </h2>

                    @if(!$profile->two_factor_enabled)
                        <form method="POST" action="{{ route('admin.2fa.enable') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                    Enter 6-digit code from your app
                                </label>
                                <input type="text" name="code" id="code" maxlength="6" pattern="[0-9]{6}" 
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-center text-lg tracking-widest focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" 
                                       placeholder="000000" required>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                Enable 2FA
                            </button>
                        </form>
                    @else
                        <div class="space-y-4">
                            <p class="text-sm text-gray-600">
                                Two-factor authentication is currently enabled for your account. 
                                You will be prompted for a code when logging in.
                            </p>
                            <form method="POST" action="{{ route('admin.2fa.disable') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        onclick="return confirm('Are you sure you want to disable 2FA?')">
                                    Disable 2FA
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Generate QR code using a simple library or service
        document.addEventListener('DOMContentLoaded', function() {
            const qrContainer = document.getElementById('qr-code');
            const qrData = @json($qrUri);
            
            // Simple QR code generation using qr-server.com API
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=192x192&data=${encodeURIComponent(qrData)}`;
            qrContainer.innerHTML = `<img src="${qrUrl}" alt="QR Code" class="w-48 h-48">`;
        });
    </script>
</x-layouts.app>
