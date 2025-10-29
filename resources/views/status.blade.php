@push('head')
<style>
  header.sticky { display: none !important; }
  /* Make the page top spacing a bit larger since header is hidden */
  main > div:first-child { margin-top: 0.5rem; }
  body { background-color: #f8fafc; }
  /* Optional: keep layout consistent */
  .page-shell { max-width: 1400px; margin: 0 auto; }
</style>
@endpush

<x-layouts.app :title="'Document Status'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.user-sidebar')

        <div class="flex-1 space-y-6">
            {{-- Document Header --}}
            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-semibold text-gray-900">{{ isset($document) ? $document->title : 'HR Policy 2023' }}</h1>
                            <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                {{ isset($document) ? $document->reference : 'DOC101' }}
                            </span>
                        </div>
                        
                        {{-- Status Badge --}}
                        @php
                            $status = isset($document) ? ($document->status ?? 'completed') : 'completed';
                        @endphp
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium
                            {{ $status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            <svg class="mr-1.5 h-2 w-2 fill-current" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3"/>
                            </svg>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2">
                        <button onclick="window.print()" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                        <button onclick="exportToPDF()" class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Document Status Timeline --}}
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Status Timeline</h2>
                        <span class="text-sm text-gray-500">
                            Last updated: {{ now()->format('M j, Y g:i A') }}
                        </span>
                    </div>

                    <div class="h-[420px] overflow-y-auto rounded-xl border p-4 bg-gradient-to-b from-gray-50 to-white">
                        <ol class="relative border-l border-gray-300 space-y-6">
                            @php
                                $statuses = [
                                    [
                                        'title' => 'Document Approved',
                                        'description' => 'Document approved and uploaded to the portal',
                                        'status' => 'completed',
                                        'date' => '2023-08-28 14:30',
                                        'user' => 'System Admin'
                                    ],
                                    [
                                        'title' => 'Final Processing',
                                        'description' => 'Formatting and quality check completed',
                                        'status' => 'completed',
                                        'date' => '2023-08-27 16:45',
                                        'user' => 'Quality Team'
                                    ],
                                    [
                                        'title' => 'Under Review',
                                        'description' => 'Compliance review and final approval',
                                        'status' => 'completed',
                                        'date' => '2023-08-26 11:20',
                                        'user' => 'Legal Team'
                                    ],
                                    [
                                        'title' => 'Initial Review',
                                        'description' => 'Content review and notes added by HR department',
                                        'status' => 'completed',
                                        'date' => '2023-08-25 09:15',
                                        'user' => 'Jane D.'
                                    ],
                                    [
                                        'title' => 'Reviewer Assigned',
                                        'description' => 'Document assigned to departmental reviewer',
                                        'status' => 'completed',
                                        'date' => '2023-08-24 13:00',
                                        'user' => 'HR Manager'
                                    ],
                                    [
                                        'title' => 'Document Creation',
                                        'description' => 'Initial document uploaded to system',
                                        'status' => 'completed',
                                        'date' => '2023-08-24 10:30',
                                        'user' => 'Document Author'
                                    ]
                                ];
                            @endphp

                            @foreach($statuses as $index => $statusItem)
                                <li class="ml-6 relative">
                                    {{-- Timeline dot --}}
                                    <div class="absolute -left-8 mt-1.5 flex h-4 w-4 items-center justify-center">
                                        @if($index === 0)
                                            <div class="h-4 w-4 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></div>
                                        @else
                                            <div class="h-3 w-3 rounded-full bg-gray-300 ring-4 ring-white"></div>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="pb-6">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $statusItem['title'] }}</h3>
                                            @if($index === 0)
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800">
                                                    Current
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ $statusItem['description'] }}</p>
                                        <div class="mt-2 flex items-center gap-4 text-xs text-gray-500">
                                            <div class="flex items-center">
                                                <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($statusItem['date'])->format('M j, Y g:i A') }}
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $statusItem['user'] }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Expected Completion --}}
                    <div class="mt-4 flex items-center justify-between rounded-lg bg-emerald-50 p-3">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-emerald-900">Status: Completed</span>
                        </div>
                        <span class="text-sm text-emerald-700">
                            Completed on: {{ isset($document) && $document->completed_at ? $document->completed_at->format('M j, Y') : '28 Aug 2023' }}
                        </span>
                    </div>
                </div>

                {{-- Document Overview --}}
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Document Overview</h2>
                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700">
                            <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Read Only
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Document Type</label>
                            <div class="relative">
                                <input 
                                    readonly 
                                    tabindex="-1"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-900 cursor-not-allowed focus:outline-none" 
                                    value="{{ isset($document) ? $document->type : 'Policy' }}" 
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Department</label>
                            <div class="relative">
                                <input 
                                    readonly 
                                    tabindex="-1"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-900 cursor-not-allowed focus:outline-none" 
                                    value="{{ isset($document) ? $document->department : 'HR' }}" 
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Document Title</label>
                            <div class="relative">
                                <input 
                                    readonly 
                                    tabindex="-1"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-900 cursor-not-allowed focus:outline-none" 
                                    value="{{ isset($document) ? $document->title : 'HR Policy 2023' }}" 
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                            <div class="relative">
                                <textarea 
                                    readonly 
                                    tabindex="-1"
                                    rows="6" 
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-900 cursor-not-allowed resize-none focus:outline-none"
                                >{{ isset($document) ? $document->description : 'The HR Policy 2023 document establishes the comprehensive framework for human resource management, outlining key policies, procedures, and guidelines that govern employee relations, recruitment, performance management, and organizational conduct. This document serves as the primary reference for HR practices and ensures compliance with regulatory requirements.' }}</textarea>
                                <div class="absolute top-2 right-2 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Additional Document Metadata --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Created Date</label>
                            <div class="relative">
                                <input 
                                    readonly 
                                    tabindex="-1"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-900 cursor-not-allowed focus:outline-none" 
                                    value="{{ isset($document) && $document->created_at ? $document->created_at->format('M j, Y') : 'Aug 24, 2023' }}" 
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Author</label>
                            <div class="relative">
                                <input 
                                    readonly 
                                    tabindex="-1"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-900 cursor-not-allowed focus:outline-none" 
                                    value="{{ isset($document) ? $document->author : 'HR Department' }}" 
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Document File Download --}}
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ isset($document) ? $document->filename : 'HR_Policy_2023.docx' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ isset($document) ? $document->file_size : '245 KB' }} • Last modified {{ isset($document) && $document->updated_at ? $document->updated_at->format('M j, Y') : 'Aug 28, 2023' }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ asset('documents/' . (isset($document) ? $document->filename : 'HR_Policy_2023.docx')) }}" 
                               class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors"
                               download>
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Print Styles --}}
    <style media="print">
        @page {
            margin: 1in;
            size: A4;
        }
        
        .no-print {
            display: none !important;
        }
        
        .print-break {
            page-break-before: always;
        }
        
        .bg-gray-50 {
            background: white !important;
        }
        
        .shadow-sm,
        .ring-1,
        .ring-black\/5 {
            box-shadow: none !important;
        }
    </style>

    <script>
        function exportToPDF() {
            // Simple PDF export functionality
            window.print();
        }

        // Auto-refresh status every 30 seconds (optional)
        setInterval(function() {
            // You can add AJAX call here to refresh status
        }, 30000);
    </script>
</x-layouts.app>