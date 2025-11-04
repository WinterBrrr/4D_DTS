@extends('layouts.app')

@section('content')
<h1>Documents</h1>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Department</th>
            <th>Type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $document)
        <tr>
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
