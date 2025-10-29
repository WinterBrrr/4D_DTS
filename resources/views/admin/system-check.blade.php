@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'System Check'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">System Check</h1>
                    <p class="text-sm text-gray-600">System health and configuration status</p>
                </div>
                <a href="{{ route('admin.settings') }}" class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Back to Settings</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($checks as $key => $check)
                    <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($check['status'] === 'ok')
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                @elseif($check['status'] === 'warning')
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                @elseif($check['status'] === 'error')
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900 capitalize">
                                    {{ str_replace('_', ' ', $key) }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $check['message'] }}</p>
                                @if($check['status'] === 'ok')
                                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Healthy
                                    </span>
                                @elseif($check['status'] === 'warning')
                                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Warning
                                    </span>
                                @elseif($check['status'] === 'error')
                                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Error
                                    </span>
                                @else
                                    <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Info
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ now()->format('Y-m-d H:i:s') }}</div>
                        <div class="text-sm text-gray-500">Current Time</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</div>
                        <div class="text-sm text-gray-500">Total Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Document::count() }}</div>
                        <div class="text-sm text-gray-500">Total Documents</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
