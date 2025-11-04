@extends('layouts.app')
@section('content')
<h1>Document Details</h1>
<p>Title: {{ $document->title }}</p>
<p>Department: {{ $document->department->name ?? '-' }}</p>
<p>Type: {{ $document->type->name ?? '-' }}</p>
<p>Status: {{ $document->status }}</p>
<p>Uploaded by: {{ $document->user->name ?? '-' }}</p>
<p><a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">Download File</a></p>
<form method="POST" action="{{ route('admin.documents.updateStatus', $document->id) }}">
    @csrf
    <label>Change Status:
        <select name="status">
            <option value="pending">Pending</option>
            <option value="reviewing">Reviewing</option>
            <option value="final_processing">Final Processing</option>
            <option value="completed">Completed</option>
        </select>
    </label>
    <button type="submit">Update</button>
</form>
@endsection