<x-layouts.app :title="'Inspect Document'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-8 flex gap-6">
        @include('partials.user-sidebar')
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-emerald-700 mb-6">Inspect Document</h1>
            <div class="rounded-3xl bg-white p-8 shadow-md ring-1 ring-emerald-100">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="font-semibold text-emerald-700">Code</dt>
                        <dd class="text-emerald-900 font-semibold">{{ $document->code ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-emerald-700">Title</dt>
                        <dd class="text-emerald-900 font-semibold">{{ $document->title ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-emerald-700">Type</dt>
                        <dd class="text-emerald-900">{{ $document->type ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-emerald-700">Handler</dt>
                        <dd class="text-emerald-900">{{ $document->handler ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-emerald-700">Department</dt>
                        <dd class="text-emerald-900">{{ $document->department ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-emerald-700">Status</dt>
                        <dd class="text-emerald-900">{{ $document->status ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-emerald-700">Expected Completion</dt>
                        <dd class="text-emerald-900">{{ $document->expected_completion_at ? \Carbon\Carbon::parse($document->expected_completion_at)->format('M d, Y') : '—' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-semibold text-emerald-700">Description</dt>
                        <dd class="text-emerald-900">{{ $document->description ?? '—' }}</dd>
                    </div>
                </dl>
                @if (!empty($document->file_path))
                    <div class="mt-8">
                        <h2 class="text-lg font-bold text-emerald-700 mb-2">Document Preview</h2>
                        <div class="bg-gray-50 border border-emerald-200 rounded-xl p-4 flex items-center justify-center" style="min-height:600px; height:800px; max-height:900px;">
                            @php
                                $ext = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                            @endphp
                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                <img src="{{ asset('storage/' . $document->file_path) }}" alt="Document Image" class="max-w-full max-h-[750px] rounded-lg border border-emerald-200 shadow-sm">
                            @elseif ($ext === 'pdf')
                                <iframe src="{{ asset('storage/' . $document->file_path) }}" class="w-full h-full border rounded-lg" frameborder="0"></iframe>
                            @else
                                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-700 w-full text-center">
                                    <span class="font-semibold">Preview not available for this file type.</span>
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="ml-2 text-emerald-600 underline">Download</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ asset('storage/' . $document->file_path) }}" download class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293L18 8" />
                        </svg>
                        Download
                    </a>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-2.5 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
