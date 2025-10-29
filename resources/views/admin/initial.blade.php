{{-- Admin Initial Review --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Initial Review'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">Initial Review</h1>
                <div class="flex items-center gap-3">
                    <form class="relative" method="GET" action="{{ route('admin.initial') }}">
                        <label for="adm-search" class="sr-only">Search</label>
                        <input id="adm-search" name="q" value="{{ request('q') }}" placeholder="Search"
                               class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
            </div>

            <!-- Document Overview Form -->
            <div class="rounded-3xl bg-white ring-1 ring-emerald-100 shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Document Overview</h2>
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Type</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="Policy" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Department</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm bg-gray-50" value="HR" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Document Title</label>
                        <input class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" value="HR Policy 2023" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                        <textarea rows="5" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">The HR Policy 2023 document establishes the comprehensive framework for human resource management...</textarea>
                    </div>
                    <div class="md:col-span-2 flex items-center justify-between">
                        <a class="text-emerald-700 text-sm" href="#">HR_Policy_2023.docx</a>
                        <div class="flex items-center gap-2">
                            <label class="block text-xs font-medium text-gray-600">Expected Completion Date</label>
                            <input type="text" class="w-40 rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="dd/mm/yy" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.workflow.set', 'under') }}" class="inline-flex items-center px-6 py-2 rounded-full bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">Proceed</a>
            </div>
        </div>
    </div>
</x-layouts.app>
