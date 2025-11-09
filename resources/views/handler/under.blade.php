{{-- Handler Under Review (Table) --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Under Review'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.handler-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Under Review</h1>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('handler.under') }}">
                        <label for="handler-search" class="sr-only">Search</label>
                        <input id="handler-search" name="q" value="{{ request('q') }}" placeholder="Search"
                               class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>
            <!-- Table: Under Review Documents -->
            <div class="bg-white rounded-2xl shadow ring-1 ring-emerald-100 p-6">
                <h2 class="text-lg font-semibold text-emerald-700 mb-4">Documents Under Review</h2>
                @php $reviewingDocuments = $reviewingDocuments ?? []; @endphp
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-emerald-100">
                        <thead class="bg-emerald-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">ID</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Title</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Type</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Owner</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Date Received</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-emerald-50">
                            @forelse($reviewingDocuments as $doc)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-gray-900">{{ $doc['id'] }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-900">{{ $doc['title'] }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $doc['type'] }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $doc['handler'] }}</td>
                                    <td class="px-3 py-2">
                                        @php
                                            $status = strtolower($doc['status']);
                                            $badgeClass = [
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'reviewing' => 'bg-blue-100 text-blue-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                'final_processing' => 'bg-purple-100 text-purple-700',
                                                'completed' => 'bg-emerald-100 text-emerald-700',
                                            ][$status] ?? 'bg-gray-100 text-gray-700';
                                            $statusSymbol = [
                                                'pending' => '🕒',
                                                'reviewing' => '🔎',
                                                'approved' => '👍',
                                                'rejected' => '❌',
                                                'final_processing' => '📄',
                                                'completed' => '✅',
                                            ][$status] ?? '';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold {{ $badgeClass }}">
                                            {{ $statusSymbol }} {{ ucfirst($doc['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $doc['uploaded_at'] }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('handler.documents.show', $doc['id']) }}" class="text-emerald-600 hover:underline text-xs">View</a>
                                        <a href="{{ route('handler.final', ['document' => $doc['id']]) }}" class="ml-2 text-emerald-700 hover:underline text-xs">Process</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">No documents under review</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
