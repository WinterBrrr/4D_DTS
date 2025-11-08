{{-- Auditor Reports Page --}}
<x-layouts.app :title="'Auditor Reports'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.auditor-sidebar')
        <div class="flex-1">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Reports &amp; Analytics</h1>
                <p class="text-sm text-gray-600">Monitor document processing performance</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                <h2 class="text-lg font-semibold text-blue-700 mb-4">Quick Stats</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-blue-700">{{ $stats['totalDocs'] ?? 0 }}</div>
                        <div class="text-sm text-blue-700 mt-2">Total Documents</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-green-700">{{ $stats['completed'] ?? 0 }}</div>
                        <div class="text-sm text-green-700 mt-2">Completed</div>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-700">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="text-sm text-yellow-700 mt-2">Pending</div>
                    </div>
                    <div class="bg-red-50 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-red-700">{{ $stats['rejected'] ?? 0 }}</div>
                        <div class="text-sm text-red-700 mt-2">Rejected</div>
                    </div>
                </div>
                <div class="mt-8 text-gray-500 text-sm">For more detailed analytics, contact the admin.</div>
            </div>
        </div>
    </div>
</x-layouts.app>
