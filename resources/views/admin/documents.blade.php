@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Documents'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold">Documents</h1>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white">Back</a>
            </div>

            <div class="mt-4 overflow-hidden rounded-3xl border border-emerald-100 bg-white shadow-sm">
                <table class="w-full text-sm text-gray-900">
                    <thead class="bg-emerald-50 text-emerald-700">
                        <tr>
                            <th class="px-3 py-2 text-left">ID</th>
                            <th class="px-3 py-2 text-left">Code</th>
                            <th class="px-3 py-2 text-left">Title</th>
                            <th class="px-3 py-2 text-left">Type</th>
                            <th class="px-3 py-2 text-left">Handler</th>
                            <th class="px-3 py-2 text-left">Department</th>
                            <th class="px-3 py-2 text-left">Status</th>
                            <th class="px-3 py-2 text-left">Expected Completion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($documents as $doc)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $doc->id }}</td>
                                <td class="px-3 py-2">{{ $doc->code }}</td>
                                <td class="px-3 py-2">{{ $doc->title }}</td>
                                <td class="px-3 py-2">{{ $doc->type }}</td>
                                <td class="px-3 py-2">{{ $doc->handler }}</td>
                                <td class="px-3 py-2">{{ $doc->department }}</td>
                                <td class="px-3 py-2">{{ $doc->status }}</td>
                                <td class="px-3 py-2">{{ $doc->expected_completion_at ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 py-6 text-center text-gray-500">No documents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $documents->links() }}</div>
        </div>
    </div>
</x-layouts.app>
