{{-- Handler Review Form --}}
<form method="POST" action="{{ route('handler.documents.review', $doc->id) }}" class="mb-4">
    @csrf
    <label class="block text-sm font-medium text-gray-700 mb-2">Change Status</label>
    <select name="status" class="w-full rounded border-gray-300 mb-2">
        <option value="reviewing">Reviewing</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">Update Status</button>
</form>
