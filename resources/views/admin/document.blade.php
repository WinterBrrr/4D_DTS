
<x-layouts.app :title="'Document Details'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-emerald-700 mb-2">Document Details</h1>
                <p class="text-sm text-gray-600">View and manage document information</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-8">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <dt class="font-semibold text-gray-700">Title</dt>
                        <dd class="text-gray-900">{{ $document->title }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Type</dt>
                        <dd class="text-gray-900">{{ $document->type }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Handler</dt>
                        <dd class="text-gray-900">{{ $document->handler }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Department</dt>
                        <dd class="text-gray-900">{{ $document->department }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Status</dt>
                        <dd class="text-gray-900">{{ $document->status }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Expected Completion</dt>
                        <dd class="text-gray-900">{{ $document->expected_completion_at ?? '—' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-semibold text-gray-700">Description</dt>
                        <dd class="text-gray-900">{{ $document->description ?? '—' }}</dd>
                    </div>
                </dl>
                <div class="mt-8 flex gap-4">
                    <a href="{{ asset('storage/' . $document->file_path) }}" download class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">Download File</a>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>