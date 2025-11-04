
<x-layouts.app :title="'Auditor Status Guide'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.auditor-sidebar')
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-blue-700">Document Status Guide (Auditor)</h1>
                    <p class="text-sm text-gray-600 mt-1">What do the document statuses mean for auditors?</p>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow ring-1 ring-blue-100">
                <ul class="space-y-4">
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold">🕒 Pending</span> — The document is waiting for action or review.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">🔎 Reviewing</span> — The document is being checked or evaluated by an auditor or handler.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">👍 Approved</span> — The document has been approved by the auditor.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">❌ Rejected</span> — The document was declined or did not pass audit.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-semibold">📄 Final Processing</span> — The document is in the final stage before completion.</li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold">✅ Completed</span> — The document workflow is finished and archived.</li>
                </ul>
                <div class="mt-8 text-sm text-gray-600">
                    <p>If you have questions about a specific status, please contact your administrator or refer to the document workflow policy.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
