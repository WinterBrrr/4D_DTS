
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Process Document'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Process Document</h1>
            </div>

            <!-- Document Overview Form -->
            <div class="rounded-3xl bg-white ring-1 ring-emerald-100 shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Document Overview</h2>
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Type</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="{{ $doc->type }}" readonly />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Department</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="{{ $doc->department }}" readonly />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Title</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" value="{{ $doc->title }}" readonly />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                        <textarea rows="5" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" readonly>{{ $doc->description }}</textarea>
                    </div>
                    <div class="md:col-span-2 flex items-center justify-between">
                        @if($doc->file_path)
                        <a class="text-emerald-700 text-sm" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ basename($doc->file_path) }}</a>
                        @else
                        <span class="text-gray-400 text-xs">No file uploaded</span>
                        @endif
                        <div class="flex items-center gap-2">
                            <label class="block text-xs font-medium text-gray-600">Expected Completion Date</label>
                            <input type="text" class="w-40 rounded-lg border border-gray-200 px-3 py-2 text-sm" value="{{ $doc->expected_completion_at ?? '' }}" readonly />
                        </div>
                    </div>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.process.handle', $doc->id) }}" class="mt-8 flex justify-end gap-3">
                @csrf
                <input type="hidden" name="comment" id="comment-input" />
                <a href="{{ route('admin.documents.show', $doc->id) }}" class="inline-flex items-center px-6 py-2 border-2 border-gray-300 rounded-full text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    View Details
                </a>
                <button type="button" onclick="processAction('reviewing')" class="inline-flex items-center px-6 py-2 bg-emerald-600 border border-transparent rounded-full text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg hover:shadow-xl transition-all duration-200">
                    Approve (Reviewing)
                </button>
                <button type="button" onclick="processAction('rejected')" class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-full text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-lg hover:shadow-xl transition-all duration-200">
                    Reject
                </button>
                <button type="button" onclick="processAction('completed')" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-full text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-200">
                    Mark as Completed
                </button>
            </form>
            <div class="mt-4 flex justify-end">
                <textarea id="comment-area" rows="2" class="w-1/2 rounded border-gray-300 text-sm" placeholder="Add a comment (optional)"></textarea>
            </div>
        </div>
    </div>
</x-layouts.app>
<script>
function processAction(status) {
    document.getElementById('comment-input').value = document.getElementById('comment-area').value;
    var form = event.target.closest('form');
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'status';
    input.value = status;
    form.appendChild(input);
    form.submit();
}
</script>
