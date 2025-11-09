{{-- Handler Status Guide --}}
<x-layouts.app :title="'Document Status Guide'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.handler-sidebar')
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-emerald-700">Document Status Guide</h1>
                    <p class="text-sm text-gray-600 mt-1">What do the document statuses mean?</p>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow ring-1 ring-emerald-100">
                <ul class="space-y-4">
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold">🕒 Pending</span> — The document is waiting for action or review.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">🔎 Reviewing</span> — The document is being checked or evaluated.</li>
                        <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">👍 Approved</span> — The document has been approved.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">❌ Rejected</span> — The document was declined or did not pass review.</li>
                </ul>
                <div class="mt-8 text-sm text-gray-600">
                    <p>If you have questions about a specific status, please contact your administrator or refer to the document workflow policy.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
