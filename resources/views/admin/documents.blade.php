@extends('layouts.app')

@section('content')
<h1>Documents</h1>

<table>
    <thead>
        <tr>
            <th>Preview</th>
            <th></th>Title</th>
            <th>Department</th>
            <th>Type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $document)
        <tr>
            <td>
                @php
                    $filePath = $document->file_path ?? null;
                    $fileExt = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                @endphp
                @if($filePath && in_array($fileExt, ['png', 'jpg', 'jpeg']))
                    <img src="{{ asset('storage/' . $filePath) }}" alt="Preview" style="max-width:60px; max-height:60px; border-radius:6px; border:1px solid #ddd;" />
                @elseif($filePath && $fileExt === 'pdf')
                    <span title="PDF File">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24"><rect width="24" height="24" rx="4" fill="#F87171"/><text x="6" y="19" font-size="10" fill="#fff">PDF</text></svg>
                    </span>
                @elseif($filePath)
                    <span title="File">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24"><rect width="24" height="24" rx="4" fill="#a3a3a3"/><text x="7" y="19" font-size="10" fill="#fff">FILE</text></svg>
                    </span>
                @else
                    <span style="color:#aaa;">—</span>
                @endif
            </td>
            <td>{{ $document->title }}</td>
            <td>{{ $document->department->name ?? '-' }}</td>
            <td>{{ $document->type->name ?? '-' }}</td>
            <td>{{ $document->status }}</td>
            <td><a href="{{ route('admin.documents.show', $document->id) }}">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
