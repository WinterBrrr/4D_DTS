<x-layouts.app :title="'Dashboard'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.sidebar')

        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold">Welcome to Dashboard!</h1>
                <form class="relative" method="GET" action="{{ route('dashboard') }}">
                    <label for="doc-search" class="sr-only">Search documents</label>
                    <input id="doc-search" name="q" value="{{ request('q') }}"
                        data-target="#doc-table"
                        class="h-9 w-64 rounded-full border border-gray-200 bg-white px-10 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Search documents" />
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </form>
            </div>

            <!-- Stats -->
            <div class="mt-4 rounded-xl bg-gradient-to-r from-emerald-400 to-teal-600 p-6 text-white">
                <div class="grid grid-cols-3 gap-6 items-end">
                    <div>
                        <div class="text-white/80">Total Documents</div>
                        <div class="text-5xl font-bold">50</div>
                    </div>
                    <div>
                        <div class="text-white/80">Processing</div>
                        <div class="text-5xl font-bold">12</div>
                    </div>
                    <div>
                        <div class="text-white/80">Completed</div>
                        <div class="text-5xl font-bold">12</div>
                    </div>
                </div>
                <div class="mt-6 text-xs text-white/80">Last Accessed: Policy_Doc_2025.PDF</div>
            </div>

            <!-- Document List -->
            <div class="mt-6">
                <h2 class="text-sm font-medium text-gray-500">Document List</h2>
                <div class="mt-2 overflow-hidden rounded-xl border bg-white">
                    <table class="w-full text-sm" id="doc-table">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Title</th>
                                <th class="px-3 py-2 text-left">Type</th>
                                <th class="px-3 py-2 text-left">Handler</th>
                                <th class="px-3 py-2 text-left">Department</th>
                                <th class="px-3 py-2 text-left">Status</th>
                                <th class="px-3 py-2 text-left">Expected Completion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($documents as $doc)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $doc->code }}</td>
                                    <td class="px-3 py-2">{{ $doc->title }}</td>
                                    <td class="px-3 py-2">{{ $doc->type }}</td>
                                    <td class="px-3 py-2">{{ $doc->handler }}</td>
                                    <td class="px-3 py-2">{{ $doc->department }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            {{ str_contains(strtolower($doc->status), 'complete') 
                                                ? 'bg-emerald-100 text-emerald-700' 
                                                : 'bg-amber-100 text-amber-700' }}">
                                            {{ $doc->status }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $doc->expected_completion_at ? \Carbon\Carbon::parse($doc->expected_completion_at)->format('M d, Y') : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-6 text-center text-gray-500">
                                        No documents found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
