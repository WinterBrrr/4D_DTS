@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Document Types'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1 space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold">Document Types</h1>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white">Back</a>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5 dark:bg-slate-900 dark:ring-slate-800">
                <h2 class="text-sm font-medium text-gray-700 mb-4">Add Type</h2>
                <form method="POST" action="{{ route('admin.types.store') }}" class="flex gap-3">
                    @csrf
                    <input name="name" class="flex-1 rounded-lg border border-gray-300 px-3 py-2 shadow-sm" placeholder="Type name (e.g. Policy)" required>
                    <button class="px-3 py-2 rounded-lg bg-emerald-600 text-white text-sm">Add</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5 dark:bg-slate-900 dark:ring-slate-800">
                <h2 class="text-sm font-medium text-gray-700 mb-4">Existing Types</h2>
                <div class="overflow-hidden rounded-xl border border-emerald-100">
                    <table class="w-full text-sm">
                        <thead class="bg-emerald-50 text-emerald-700">
                            <tr>
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Slug</th>
                                <th class="px-3 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($types as $t)
                                <tr>
                                    <td class="px-3 py-2">{{ $t->id }}</td>
                                    <td class="px-3 py-2">{{ $t->name }}</td>
                                    <td class="px-3 py-2">{{ $t->slug }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <form method="POST" action="{{ route('admin.types.delete') }}" onsubmit="return confirm('Delete this type?')" class="inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $t->id }}">
                                            <button class="px-3 py-1.5 rounded bg-red-600 text-white">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-6 text-center text-gray-500">No types yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
