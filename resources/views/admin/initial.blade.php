{{-- Admin Initial Review --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Initial Review'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Processing of the Document</h1>
            </div>

            <!-- Document Overview Form -->
            <div class="rounded-3xl bg-white ring-1 ring-emerald-100 shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Document Overview</h2>
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4" method="POST" action="{{ route('admin.initial.submit', $currentDocument?->id) }}">
                    @csrf
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Type</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="{{ $currentDocument?->type ?? '' }}" readonly disabled />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Department</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="{{ $currentDocument?->department ?? '' }}" readonly disabled />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Title</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="{{ $currentDocument?->title ?? '' }}" readonly disabled />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                        <textarea rows="5" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" readonly disabled>{{ $currentDocument?->description ?? '' }}</textarea>
                    </div>
                    <div class="md:col-span-2 flex items-center justify-between">
                        <div>
                        @if(!empty($currentDocument?->file_path))
                            <a class="text-emerald-700 text-sm font-medium hover:underline" href="{{ asset('storage/' . $currentDocument->file_path) }}" target="_blank">View Document</a>
                        @else
                            <span class="text-gray-400 text-sm">No file</span>
                        @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="block text-xs font-medium text-gray-600">Expected Completion Date</label>
                            <input type="date" name="expected_completion_at" class="w-40 rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="{{ $currentDocument?->expected_completion_at ?? '' }}" />
                        </div>
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Comments <span class="text-red-500">*</span></label>
                        <textarea name="comments" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" required placeholder="Enter your comments here..."></textarea>
                    </div>
                    <div class="md:col-span-2 mt-4">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Change Status</label>
                        <select name="status" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" required>
                            <option value="pending" {{ $currentDocument?->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewing" {{ $currentDocument?->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                            <option value="rejected" {{ $currentDocument?->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="approved" {{ $currentDocument?->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>
                    <div class="flex justify-end mt-2 md:mt-0 md:col-span-2">
                        <button type="submit" class="inline-flex items-center px-6 py-2 rounded-full bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
