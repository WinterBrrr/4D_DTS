{{-- Admin Upload Template --}}
<x-layouts.app :title="'Admin Document Upload'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">
            <div class="mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-emerald-700">Admin Document Upload</h1>
                    <div class="flex items-center gap-3">
                        <form class="relative" method="GET" action="{{ route('admin.upload') }}">
                            <label for="adm-search" class="sr-only">Search</label>
                            <input id="adm-search" name="q" value="{{ request('q') }}" class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Search" />
                            <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd" />
                            </svg>
                        </form>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Upload documents directly to the system for processing</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5">
                <form method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    {{-- File Upload Section --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-emerald-400 hover:bg-emerald-50/50 transition-colors cursor-pointer" id="upload-area">
                        <input 
                            type="file" 
                            id="file" 
                            name="file" 
                            class="hidden" 
                            accept=".pdf,.doc,.docx,.txt,.xlsx,.pptx"
                            required
                        />
                        <div id="upload-prompt">
                            <svg class="mx-auto w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Upload Document</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                <span class="font-medium text-emerald-600">Click to browse</span> or drag and drop files here
                            </p>
                            <p class="text-xs text-gray-500">
                                Supported formats: PDF, DOC, DOCX, TXT, XLSX, PPTX (Max 10MB)
                            </p>
                        </div>
                        <div id="file-preview" class="hidden">
                            <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div class="text-left">
                                        <p id="file-name" class="text-sm font-medium text-gray-900"></p>
                                        <p id="file-size" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <button type="button" id="remove-file" class="text-red-500 hover:text-red-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Document Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Document Type *</label>
                            <select 
                                id="document_type" 
                                name="document_type" 
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" 
                                required
                            >
                                <option value="">Select document type</option>
                                <option value="Policy">Policy</option>
                                <option value="Procedures(SOP)">Procedures(SOP)</option>
                                <option value="Guidelines">Guidelines</option>
                                <option value="Manuals">Manuals</option>
                                <option value="Report">Report</option>
                                <option value="Plans">Plans</option>
                                <option value="Memo">Memo</option>
                                <option value="Others">Others</option>
                            </select>
                            @error('document_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                            <select 
                                id="department" 
                                name="department" 
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" 
                                required
                            >
                                <option value="">Select department</option>
                                <option value="CIT">CIT</option>
                                <option value="COE">COE</option>
                                <option value="COM">COM</option>
                                <option value="CAS">CAS</option>
                                <option value="ICJE">ICJE</option>
                                <option value="COT">COT</option>
                                <option value="CE">CE</option>
                                <option value="ADMIN">ADMIN</option>
                            </select>
                            @error('department')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Document Title *</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" 
                                value="{{ old('title') }}" 
                                placeholder="Enter document title"
                                required 
                            />
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4" 
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                placeholder="Provide a description of the document content and purpose..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- Submit Button --}}
                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <button 
                            type="submit" 
                            id="submit-btn"
                            class="inline-flex items-center px-8 py-3 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- JavaScript for file upload --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const uploadArea = document.getElementById('upload-area');
            const uploadPrompt = document.getElementById('upload-prompt');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const removeFileBtn = document.getElementById('remove-file');
            const submitBtn = document.getElementById('submit-btn');
            // Click to upload
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                handleFile(e.target.files[0]);
            });
            // Drag and drop handlers
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-emerald-500', 'bg-emerald-50');
            });
            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-emerald-500', 'bg-emerald-50');
            });
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-emerald-500', 'bg-emerald-50');
                const file = e.dataTransfer.files[0];
                if (file) {
                    fileInput.files = e.dataTransfer.files;
                    handleFile(file);
                }
            });
            // Remove file handler
            removeFileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                fileInput.value = '';
                uploadPrompt.classList.remove('hidden');
                filePreview.classList.add('hidden');
                submitBtn.disabled = true;
            });
            function handleFile(file) {
                if (file) {
                    // Validate file size (10MB limit)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size must be less than 10MB');
                        return;
                    }
                    // Validate file type
                    const allowedTypes = ['.pdf', '.doc', '.docx', '.txt', '.xlsx', '.pptx'];
                    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                    if (!allowedTypes.includes(fileExtension)) {
                        alert('Please select a valid file type: ' + allowedTypes.join(', '));
                        return;
                    }
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    uploadPrompt.classList.add('hidden');
                    filePreview.classList.remove('hidden');
                    submitBtn.disabled = false;
                }
            }
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
</x-layouts.app>