@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
@push('head')
<style>
    header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'My Documents'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.user-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">My Documents</h1>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <ul class="flex border-b border-emerald-200">
                    <li>
                        <a href="?tab=sent" class="px-4 py-2 -mb-px border-b-2 {{ $tab === 'sent' ? 'border-emerald-600 text-emerald-700 font-semibold' : 'border-transparent text-gray-500 hover:text-emerald-700' }}">Sent</a>
                    </li>
                    <li>
                        <a href="?tab=received" class="px-4 py-2 -mb-px border-b-2 {{ $tab === 'received' ? 'border-emerald-600 text-emerald-700 font-semibold' : 'border-transparent text-gray-500 hover:text-emerald-700' }}">Received</a>
                    </li>
                </ul>
            </div>

            <!-- Table: Documents -->
            <div class="bg-white rounded-2xl shadow ring-1 ring-emerald-100 p-6">
                <h2 class="text-lg font-semibold text-emerald-700 mb-4">{{ ucfirst($tab) }} Documents</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-emerald-100">
                        <thead class="bg-emerald-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">ID</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Title</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Type</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Sent To</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Date</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-emerald-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-emerald-50">
                            @forelse($documents as $doc)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-gray-900">{{ $doc->id }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-900">{{ $doc->title }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $doc->type }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $doc->department }}</td>
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
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold {{ $badgeClass }}">
                                            @switch($status)
                                                @case('pending')
                                                    🕒 Pending
                                                    @break
                                                @case('reviewing')
                                                    🔎 Reviewing
                                                    @break
                                                @case('approved')
                                                    👍 Approved
                                                    @break
                                                @case('rejected')
                                                    ❌ Rejected
                                                    @break
                                                @case('final_processing')
                                                    📄 Final
                                                    @break
                                                @case('completed')
                                                    ✅ Completed
                                                    @break
                                                @default
                                                    {{ ucfirst($doc->status) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $tab === 'sent' ? $doc->created_at->format('Y-m-d') : $doc->updated_at->format('Y-m-d') }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('inspect', $doc->id) }}" class="text-emerald-600 hover:underline text-xs">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No documents found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
