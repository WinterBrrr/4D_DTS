{{-- Document View Template --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Document View'" :compactSidebar="true" :hideGlobalHeader="true">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        
        <div class="flex-1">
            {{-- Breadcrumb --}}
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-emerald-600">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-500">Document View</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $currentDocument['title'] ?? 'Document Details' }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Review document details and manage workflow</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                        <svg class="mr-1.5 size-2 fill-current" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        {{ ucfirst($currentDocument['status'] ?? 'pending') }}
                    </span>
                </div>

                @if(isset($currentDocument))
                    {{-- Document Information --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Document Type</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($currentDocument['type']) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Department</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($currentDocument['department']) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Submitter</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $currentDocument['submitter'] }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upload Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $currentDocument['uploaded_at'] }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">File Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $currentDocument['filename'] }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $currentDocument['status'])) }}</p>
                            </div>
                        </div>
                    </div>

                    @if(isset($currentDocument['description']))
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900">{{ $currentDocument['description'] }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- File Preview/Download --}}
                    <div class="border border-gray-200 rounded-lg p-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $currentDocument['filename'] }}</h4>
                                    <p class="text-xs text-gray-500">Document file</p>
                                </div>
                            </div>
                            <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </button>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <button 
                            type="button" 
                            onclick="window.history.back()"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors"
                        >
                            <svg class="mr-2 -ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </button>
                        
                        <div class="flex space-x-3">
                            @if($currentDocument['status'] === 'pending')
                                <form method="POST" action="{{ route('admin.proceed', ['step' => 'pending']) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="document" value="{{ $currentDocument['id'] }}">
                                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                        Start Review
                                        <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </form>
                            @elseif($currentDocument['status'] === 'reviewing')
                                <a href="{{ route('admin.under', ['document' => $currentDocument['id']]) }}" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Continue Review
                                    <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            @elseif($currentDocument['status'] === 'final_processing')
                                <a href="{{ route('admin.final', ['document' => $currentDocument['id']]) }}" class="inline-flex items-center px-6 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    Final Processing
                                    <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Document not found</h3>
                        <p class="text-gray-500 mb-4">The requested document could not be located.</p>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700">
                            Return to Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>