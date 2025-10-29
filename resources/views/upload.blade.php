@push('head')
<style>
  /* Hide the global header so the upload page matches the dashboard app shell */
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Upload Document'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.user-sidebar')

        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Upload Document</h1>
                    <p class="text-sm text-gray-600 mt-1">Share and manage your documents</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input 
                            id="search" 
                            class="h-10 w-64 rounded-full border border-emerald-200 bg-white px-10 text-sm placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                            placeholder="Search" 
                        />
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    @php($pUser = \App\Models\User::where('email', Session::get('user_email'))->first())
                    @php($profile = $pUser ? \App\Models\UserProfile::where('user_id', $pUser->id)->first() : null)
                    @php($photoPath = session('profile_photo_path') ?: ($profile?->profile_photo_path))
                    <a href="{{ route('profile.show') }}" title="Profile"
                       class="relative grid place-items-center h-10 w-10 rounded-full bg-white border border-emerald-200 shadow-sm overflow-hidden">
                        @if(!empty($photoPath))
                            <span class="absolute inset-0" style="background: url('{{ asset('storage/'.$photoPath) }}?v={{ now()->timestamp }}') center 20% / cover no-repeat;"></span>
                        @else
                            <span class="text-sm font-semibold text-emerald-700 z-10">
                                {{ strtoupper(substr(Session::get('user_name', Session::get('user_email', 'U')), 0, 1)) }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mt-4 rounded-md border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800" role="alert">
                    {{ session('success') }} — 
                    <span class="font-medium">{{ session('uploaded_path') }}</span>
                </div>
            @endif

            <!-- Upload Form -->
            <form method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data" class="mt-4 space-y-6">
                @csrf

                <!-- Step 1: Document Information -->
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                        <span class="grid h-6 w-6 place-items-center rounded-full bg-emerald-500 text-white text-xs font-semibold">1</span>
                        <span class="font-semibold text-gray-900">Document Information</span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                            <select id="document_type" name="document_type" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('document_type') border-red-500 @enderror" aria-describedby="document_type-error">
                                <option value="">Select document type</option>
                                <option {{ old('document_type') == 'Policy' ? 'selected' : '' }}>Policy</option>
                                <option {{ old('document_type') == 'Guide' ? 'selected' : '' }}>Guide</option>
                                <option {{ old('document_type') == 'Report' ? 'selected' : '' }}>Report</option>
                            </select>
                            @error('document_type')<p id="document_type-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                            <select id="department" name="department" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('department') border-red-500 @enderror" aria-describedby="department-error">
                                <option value="">Select department</option>
                                <option {{ old('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                <option {{ old('department') == 'IT' ? 'selected' : '' }}>IT</option>
                                <option {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                            @error('department')<p id="department-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Document Title</label>
                            <input id="title" name="title" value="{{ old('title') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title') border-red-500 @enderror" placeholder="Enter a descriptive title for your document" aria-describedby="title-error" />
                            @error('title')<p id="title-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description <span class="text-gray-500 font-normal">(Optional)</span></label>
                            <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 @enderror" placeholder="Add relevant details, information, and any specific instructions necessary for clarity and completeness." aria-describedby="description-error">{{ old('description') }}</textarea>
                            @error('description')<p id="description-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: File Upload -->
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                        <span class="grid h-6 w-6 place-items-center rounded-full bg-emerald-500 text-white text-xs font-semibold">2</span>
                        <span class="font-semibold text-gray-900">File Upload</span>
                    </div>

                    <div class="relative">
                        <label for="file-upload" class="block rounded-2xl border-2 border-dashed border-gray-300 bg-gradient-to-br from-gray-50 to-gray-100 p-12 text-center cursor-pointer transition-all duration-300 hover:border-emerald-400 hover:bg-gradient-to-br hover:from-emerald-50 hover:to-teal-50 group" 
                               id="drop-zone"
                               ondragover="event.preventDefault(); this.classList.add('border-emerald-500', 'bg-emerald-50')" 
                               ondragleave="this.classList.remove('border-emerald-500', 'bg-emerald-50')"
                               ondrop="event.preventDefault(); this.classList.remove('border-emerald-500', 'bg-emerald-50'); handleFileDrop(event, this);">
                            <input type="file" id="file-upload" name="file" class="hidden" accept=".pdf,.doc,.docx,.txt,.xlsx,.pptx" onchange="handleFileSelect(this)" />
                            
                            <div class="flex flex-col items-center" id="upload-content">
                                <!-- Upload Icon -->
                                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-emerald-200 transition-colors duration-300">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                
                                <!-- Text -->
                                <div class="mb-2">
                                    <span class="text-base font-semibold text-gray-700 group-hover:text-emerald-600 transition-colors duration-300">Click to upload</span>
                                    <span class="text-base text-gray-500"> or drag and drop</span>
                                </div>
                                <p class="text-sm text-gray-500">PDF, DOC, DOCX, TXT, XLSX, PPTX (MAX. 10MB)</p>
                                
                                <!-- Selected File Display -->
                                <div id="file-info" class="hidden mt-4 p-4 bg-white rounded-lg border border-emerald-200 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate" id="file-name"></p>
                                            <p class="text-xs text-gray-500" id="file-size"></p>
                                        </div>
                                        <button type="button" onclick="clearFile()" class="text-gray-400 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('file')<p class="mt-2 text-sm text-red-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                </div>
                
                <script>
                function handleFileSelect(input) {
                    if (input.files && input.files[0]) {
                        displayFileInfo(input.files[0]);
                    }
                }
                
                function handleFileDrop(event, label) {
                    const files = event.dataTransfer.files;
                    if (files.length > 0) {
                        document.getElementById('file-upload').files = files;
                        displayFileInfo(files[0]);
                    }
                }
                
                function displayFileInfo(file) {
                    const fileInfo = document.getElementById('file-info');
                    const fileName = document.getElementById('file-name');
                    const fileSize = document.getElementById('file-size');
                    const uploadContent = document.getElementById('upload-content');
                    
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    fileInfo.classList.remove('hidden');
                    uploadContent.querySelector('div:first-child').classList.add('hidden');
                    uploadContent.querySelector('div:nth-child(2)').classList.add('hidden');
                    uploadContent.querySelector('p').classList.add('hidden');
                }
                
                function clearFile() {
                    const input = document.getElementById('file-upload');
                    const fileInfo = document.getElementById('file-info');
                    const uploadContent = document.getElementById('upload-content');
                    
                    input.value = '';
                    fileInfo.classList.add('hidden');
                    uploadContent.querySelector('div:first-child').classList.remove('hidden');
                    uploadContent.querySelector('div:nth-child(2)').classList.remove('hidden');
                    uploadContent.querySelector('p').classList.remove('hidden');
                }
                
                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
                }
                </script>

                <!-- Submit -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-2.5 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
