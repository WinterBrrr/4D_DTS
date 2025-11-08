{{-- Admin Dashboard Template --}}

<x-layouts.app :title="'Admin Dashboard'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Welcome to Dashboard!</h1>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('admin.dashboard') }}">
                        <label for="adm-search" class="sr-only">Search</label>
                        <input id="adm-search" name="q" value="{{ request('q') }}" class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Search" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>
            <!-- ...existing code... -->
            <!-- Stats Card -->
            <div class="rounded-3xl bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white shadow-sm">
                <div class="grid grid-cols-3 gap-6 items-center">
                    <div class="text-center">
                        <div class="text-white/85">Total Documents</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['total'] ?? 0 }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-white/85">Pending</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['pending'] ?? 0 }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-white/85">Completed</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['completed'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="mt-4 text-xs text-white/85 text-right">Last Accessed: {{ $recentActivity[0]['title'] ?? '—' }}</div>
            </div>
            <!-- Document List -->
            <div class="mt-6">
                <h2 class="text-sm font-medium text-gray-600">Document List</h2>
                <div class="mt-2 overflow-hidden rounded-3xl border border-emerald-100 bg-white shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-emerald-50 text-emerald-700">
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
                        <tbody class="divide-y divide-gray-100">
                            @forelse($docs as $doc)
                                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='/admin/documents/{{ $doc->id }}'">
                                    <td class="px-3 py-2">{{ $doc->id }}</td>
                                    <td class="px-3 py-2">{{ $doc->title }}</td>
                                    <td class="px-3 py-2">{{ $doc->type }}</td>
                                    <td class="px-3 py-2">{{ $doc->handler ?? '\u2014' }}</td>
                                    <td class="px-3 py-2">{{ $doc->department }}</td>
                                    <td class="px-3 py-2">
                                        @php
                                            $status = strtolower($doc->status);
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
                                            {{ $statusSymbol }} {{ ucfirst($doc->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">{{ $doc->expected_completion_at ?? '\u2014' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-6 text-center text-gray-500">No documents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ...existing code... -->
            <div class="mt-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-emerald-100">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                @if(isset($recentActivity) && count($recentActivity) > 0)
                    <div class="space-y-3">
                        @foreach($recentActivity as $activity)
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 truncate">{{ $activity['title'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['uploaded_at'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">No recent activity</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>