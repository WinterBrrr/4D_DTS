{{-- Admin Completing (File Upload) --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Completing'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Completing</h1>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('admin.completed') }}">
                        <label for="adm-search" class="sr-only">Search</label>
                        <input id="adm-search" name="q" value="{{ request('q') }}" placeholder="Search"
                               class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>

            <!-- File Upload -->
            <div class="rounded-3xl bg-white ring-1 ring-emerald-100 shadow-sm p-8">
                <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-12 text-center cursor-pointer"
                     ondragover="event.preventDefault()"
                     ondrop="event.preventDefault(); this.querySelector('input[type=file]').files = event.dataTransfer.files; this.querySelector('[data-file]').textContent = event.dataTransfer.files[0].name;">
                    <input type="file" name="file" class="hidden"
                           onchange="this.closest('div').querySelector('[data-file]').textContent = this.files?.[0]?.name || 'Click to browse or drag and drop files here'" />
                    <svg class="mx-auto w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <div class="mt-2 text-sm text-gray-500" data-file>Click to browse or drag and drop files here</div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.completed') }}" class="inline-flex items-center px-6 py-2 rounded-full bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">Submit</a>
            </div>
        </div>
    </div>
</x-layouts.app>
