{{-- Handler Dashboard Template --}}

<x-layouts.app :title="'Handler Dashboard'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.handler-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Welcome to Handler Dashboard!</h1>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('handler.dashboard') }}">
                        <label for="handler-search" class="sr-only">Search</label>
                        <input id="handler-search" name="q" value="{{ request('q') }}" class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Search" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>
            <!-- Stats Card -->
            <div class="rounded-3xl bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white shadow-sm">
                <div class="grid grid-cols-3 gap-6 items-center">
                    <div class="text-center">
                        <div class="text-white/85">Assigned Documents</div>
                        <div class="text-6xl font-extrabold drop-shadow-sm">{{ $stats['assigned'] ?? 0 }}</div>
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
            </div>
            <!-- Document List -->
            <div class="mt-6">
                <h2 class="text-sm font-medium text-gray-600">Assigned Documents</h2>
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
                            @forelse($documents as $doc)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $doc->id }}</td>
                                    <td class="px-3 py-2">{{ $doc->title }}</td>
                                    <td class="px-3 py-2">{{ $doc->type }}</td>
                                    <td class="px-3 py-2">{{ $doc->handler ?? '—' }}</td>
                                    <td class="px-3 py-2">{{ $doc->department }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            {{ isset($doc->status) && str_contains(strtolower($doc->status), 'complete') 
                                                ? 'bg-emerald-100 text-emerald-700' 
                                                : 'bg-amber-100 text-amber-700' }}">
                                            {{ $doc->status }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">{{ $doc->expected_completion_at ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="px-3 pb-6">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                @include('partials.handler-review-form', ['doc' => $doc])
                                                @include('partials.handler-forward-form', ['doc' => $doc])
                                                @include('partials.handler-timeline-form', ['doc' => $doc])
                                            </div>
                                            <div>
                                                @include('partials.handler-comment-form', ['doc' => $doc])
                                                <div class="mt-2">
                                                    <h4 class="text-xs font-semibold text-gray-600 mb-2">Comments/Feedback</h4>
                                                    @foreach($doc->comments ?? [] as $comment)
                                                        <div class="mb-2 p-2 bg-gray-50 rounded">
                                                            <strong>{{ $comment->user->name ?? 'Handler' }}:</strong> {{ $comment->comment }}
                                                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                                        </div>
                                                    @endforeach
                                                    @if(empty($doc->comments) || count($doc->comments) === 0)
                                                        <div class="text-xs text-gray-400">No comments yet.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
        </div>
    </div>
</x-layouts.app>
