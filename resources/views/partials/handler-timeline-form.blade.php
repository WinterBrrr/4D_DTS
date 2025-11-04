{{-- Handler Timeline Update Form --}}
<form method="POST" action="{{ route('handler.documents.updateTimeline', $doc->id) }}" class="mb-4">
    @csrf
    <label class="block text-sm font-medium text-gray-700 mb-2">Update Expected Completion Date</label>
    <input type="date" name="expected_completion_at" class="w-full rounded border-gray-300 mb-2" required>
    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded">Update Timeline</button>
</form>
