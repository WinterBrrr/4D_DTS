<x-layouts.app :title="'Upload Document'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.sidebar')

        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold">Upload Document</h1>
                <div class="relative">
                    <input 
                        id="search" 
                        class="h-9 w-64 rounded-full border border-gray-200 bg-white px-10 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                        placeholder="Search" 
                    />
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 3.9 12.285l3.782 3.783a.75.75 0 1 0 1.06-1.06l-3.783-3.783A6.75 6.75 0 0 0 10.5 3.75Zm-5.25 6.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Z" clip-rule="evenodd"/>
                    </svg>
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
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="grid h-5 w-5 place-items-center rounded-full bg-emerald-500 text-white text-xs">1</span>
                        <span class="font-medium text-gray-800">Document Information</span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="document_type" class="text-xs text-gray-500">Document Type</label>
                            <select id="document_type" name="document_type" class="mt-1 w-full rounded-lg border px-3 py-2 text-sm @error('document_type') border-red-500 @else border-gray-200 @enderror" aria-describedby="document_type-error">
                                <option value="">Select document type</option>
                                <option {{ old('document_type') == 'Policy' ? 'selected' : '' }}>Policy</option>
                                <option {{ old('document_type') == 'Guide' ? 'selected' : '' }}>Guide</option>
                                <option {{ old('document_type') == 'Report' ? 'selected' : '' }}>Report</option>
                            </select>
                            @error('document_type')<p id="document_type-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="department" class="text-xs text-gray-500">Department</label>
                            <select id="department" name="department" class="mt-1 w-full rounded-lg border px-3 py-2 text-sm @error('department') border-red-500 @else border-gray-200 @enderror" aria-describedby="department-error">
                                <option value="">Select department</option>
                                <option {{ old('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                <option {{ old('department') == 'IT' ? 'selected' : '' }}>IT</option>
                                <option {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                            @error('department')<p id="department-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="title" class="text-xs text-gray-500">Document Title</label>
                            <input id="title" name="title" value="{{ old('title') }}" class="mt-1 w-full rounded-lg border px-3 py-2 text-sm @error('title') border-red-500 @else border-gray-200 @enderror" placeholder="Enter a descriptive title for your document" aria-describedby="title-error" />
                            @error('title')<p id="title-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="text-xs text-gray-500">Description</label>
                            <textarea id="description" name="description" rows="4" class="mt-1 w-full rounded-lg border px-3 py-2 text-sm @error('description') border-red-500 @else border-gray-200 @enderror" placeholder="Add relevant details, information, and any specific instructions necessary for clarity and completeness." aria-describedby="description-error">{{ old('description') }}</textarea>
                            @error('description')<p id="description-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: File Upload -->
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span class="grid h-5 w-5 place-items-center rounded-full bg-emerald-500 text-white text-xs">2</span>
                        <span class="font-medium text-gray-800">File Upload</span>
                    </div>

                    <label class="mt-4 block rounded-xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center cursor-pointer" 
                           ondragover="event.preventDefault()" 
                           ondrop="event.preventDefault(); this.querySelector('input[type=file]').files = event.dataTransfer.files; this.querySelector('[data-file]').textContent = event.dataTransfer.files[0].name;">
                        <input type="file" name="file" class="hidden" onchange="this.closest('label').querySelector('[data-file]').textContent = this.files?.[0]?.name || 'Click to browse or drag and drop files here'" />
                        <svg class="mx-auto size-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.25a.75.75 0 0 1 .75.75V12h4.5a.75.75 0 0 1 0 1.5h-4.5v4.5a.75.75 0 0 1-1.5 0v-4.5h-4.5a.75.75 0 0 1 0-1.5h4.5V3a.75.75 0 0 1 .75-.75Z"/>
                        </svg>
                        <div class="mt-2 text-xs text-gray-500" data-file>Click to browse or drag and drop files here</div>
                    </label>
                    @error('file')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center rounded-full bg-emerald-500 px-6 py-2 text-sm font-medium text-white hover:bg-emerald-600">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
