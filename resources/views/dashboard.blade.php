
@push('head')
<style>
  /* Hide global header on dashboard for mockup parity */
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Dashboard'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.user-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Welcome Back!</h1>
                    <p class="text-sm text-gray-600 mt-1">Track and manage your documents</p>
                </div>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('dashboard') }}">
                        <label for="doc-search" class="sr-only">Search documents</label>
                        <input id="doc-search" name="q" value="{{ request('q') }}"
                            data-target="#doc-table"
                            class="h-10 w-64 rounded-full border border-emerald-200 bg-white/90 px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Search" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>
            <!-- Stats Card (Rounded Gradient) -->
            <div class="rounded-3xl bg-gradient-to-r from-emerald-500 to-teal-600 p-8 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-row gap-8 items-center justify-between">
                    <div class="text-center flex-1">
                        <div class="text-white/85 font-bold">Total Documents</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['total'] ?? 0 }}</div>
                    </div>
                    <div class="text-center flex-1">
                        <div class="text-white/85 font-bold">Pending</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['pending'] ?? 0 }}</div>
                    </div>
                    <div class="text-center flex-1">
                        <div class="text-white/85 font-bold">Reviewing</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['reviewing'] ?? 0 }}</div>
                    </div>
                    <div class="text-center flex-1">
                        <div class="text-white/85 font-bold">Completed</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ ($stats['approved'] ?? 0) + ($stats['rejected'] ?? 0) }}</div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-white/20 text-sm text-white/90 flex items-center justify-end">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Last Accessed: <span class="font-medium ml-1">{{ $stats['lastAccessedTitle'] ?? '—' }}</span>
                </div>
            </div>
            <!-- Document List -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Documents</h2>
                    <span class="text-sm text-gray-500">{{ $documents->total() }} total</span>
                </div>
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <table class="w-full text-sm text-gray-900" id="doc-table">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Handler</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Expected Completion</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($documents as $doc)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $doc->code }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $doc->title }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $doc->type }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $doc->handler }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $doc->department }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                            @php
                                                $status = strtolower($doc->status);
                                                $badgeClass = [
                                                    'pending' => 'bg-amber-100 text-amber-700',
                                                    'reviewing' => 'bg-blue-100 text-blue-700',
                                                    'processing' => 'bg-indigo-100 text-indigo-700',
                                                    'final' => 'bg-purple-100 text-purple-700',
                                                    'final_processing' => 'bg-purple-100 text-purple-700',
                                                    'completed' => 'bg-emerald-100 text-emerald-700',
                                                    'approved' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                ][$status] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            {{ $badgeClass }}">
                                            @switch($status)
                                                @case('pending')
                                                    🕒 Pending
                                                    @break
                                                @case('reviewing')
                                                    🔎 Reviewing
                                                    @break
                                                @case('processing')
                                                    ⚙️ Processing
                                                    @break
                                                @case('final')
                                                @case('final_processing')
                                                    📄 Final
                                                    @break
                                                @case('completed')
                                                    ✅ Completed
                                                    @break
                                                @case('approved')
                                                    👍 Approved
                                                    @break
                                                @case('rejected')
                                                    ❌ Rejected
                                                    @break
                                                @default
                                                    {{ ucfirst($doc->status) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $doc->expected_completion_at ? \Carbon\Carbon::parse($doc->expected_completion_at)->format('M d, Y') : '—' }}
                                    </td>
                                        <td class="px-4 py-3 text-right flex gap-2 justify-end">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" download title="Download" class="inline-flex items-center justify-center h-8 w-8 rounded-full text-emerald-600 hover:bg-emerald-50 transition-colors duration-200">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293L18 8" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('inspect', $doc->id) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-3 py-2 text-blue-700 hover:bg-blue-100 transition" title="Inspect Document">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="mt-2 text-sm font-medium text-gray-900">No documents found</p>
                                        <p class="mt-1 text-sm text-gray-500">Start by uploading your first document</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $documents->links() }}
        </div>
    </div>
</x-layouts.app>
