<x-layouts.app :title="'Document Details'">
    <div class="mx-auto w-full max-w-[900px] px-4 py-8">
        <h1 class="text-2xl font-bold text-emerald-700 mb-6">Document Details</h1>
        <div class="rounded-3xl bg-white p-8 shadow-md ring-1 ring-emerald-100">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="font-semibold text-gray-700">Code</dt>
                    <dd class="text-gray-900">{{ $doc->code }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Title</dt>
                    <dd class="text-gray-900">{{ $doc->title }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Type</dt>
                    <dd class="text-gray-900">{{ $doc->type }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Handler</dt>
                    <dd class="text-gray-900">{{ $doc->handler }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Department</dt>
                    <dd class="text-gray-900">{{ $doc->department }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Status</dt>
                    <dd class="text-gray-900">
                        @include('partials.status-badge', ['status' => $doc->status])
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Expected Completion</dt>
                    <dd class="text-gray-900">{{ $doc->expected_completion_at ? \Carbon\Carbon::parse($doc->expected_completion_at)->format('M d, Y') : '—' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="font-semibold text-gray-700">Description</dt>
                    <dd class="text-gray-900">{{ $doc->description ?? '—' }}</dd>
                </div>
            </dl>
            <div class="mt-8 flex justify-end">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-2.5 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
