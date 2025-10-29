{{-- Admin Pending (Cards) --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Pending'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Pending</h1>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('admin.pending') }}">
                        <label for="adm-search" class="sr-only">Search</label>
                        <input id="adm-search" name="q" value="{{ request('q') }}" placeholder="Search"
                               class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>

            <!-- Card Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @php $items = Session::get('uploaded_documents', []); @endphp
                @forelse($items as $doc)
                    <div class="rounded-3xl bg-white ring-1 ring-emerald-100 shadow-sm p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $doc['title'] }}</h3>
                                <p class="text-xs text-gray-500">{{ $doc['id'] ?? ('DOC'.str_pad($loop->iteration,3,'0',STR_PAD_LEFT)) }}</p>
                            </div>
                            <a class="text-gray-400 hover:text-gray-600" href="#" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-1v2m-7 9l4 4m0 0l10-10a2.828 2.828 0 00-4-4L7 14m4 4H7"/></svg>
                            </a>
                        </div>
                        <div class="mt-4 space-y-2 text-xs text-gray-600">
                            <div class="flex items-center justify-between">
                                <span>Reviewer Assigned</span>
                                <span>{{ now()->format('d M H:i') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Document Creation</span>
                                <span>{{ $doc['uploaded_at'] }}</span>
                            </div>
                        </div>
                        <div class="mt-5 flex justify-end">
                            <a href="{{ route('admin.workflow.set', 'initial') }}" class="inline-flex items-center px-5 py-2 rounded-full bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">Process</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">No pending items</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
