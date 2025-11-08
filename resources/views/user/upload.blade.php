
<x-layouts.app :title="'Upload Document'">
    <div class="app-shell main-flex">
        @include('partials.user-sidebar')
        <div class="flex-1">
            <div class="header-flex mb-6">
                <h1 class="header-title">Upload Document</h1>
            </div>
            <div class="upload-form-card">
                <form method="POST" action="{{ route('documents.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required autofocus>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" name="type" id="type" class="form-input" value="{{ old('type') }}" required>
                        @error('type')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="handler" class="form-label">Handler</label>
                        <input type="text" name="handler" id="handler" class="form-input" value="{{ old('handler') }}" required>
                        @error('handler')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" name="department" id="department" class="form-input" value="{{ old('department') }}" required>
                        @error('department')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" name="status" id="status" class="form-input" value="{{ old('status') }}" required>
                        @error('status')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="expected_completion_at" class="form-label">Expected Completion</label>
                        <input type="date" name="expected_completion_at" id="expected_completion_at" class="form-input" value="{{ old('expected_completion_at') }}">
                        @error('expected_completion_at')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-input">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file" class="form-label">File</label>
                        <input type="file" name="file" id="file" class="form-input" required>
                        @error('file')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
