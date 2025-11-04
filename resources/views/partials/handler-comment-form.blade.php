{{-- Handler Comment Form --}}
<form method="POST" action="{{ route('handler.documents.comment', $doc->id) }}" class="mb-4">
    @csrf
    <label class="block text-sm font-medium text-gray-700 mb-2">Add Comment/Feedback</label>
    <textarea name="comment" rows="3" class="w-full rounded border-gray-300 mb-2" required></textarea>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Add Comment</button>
</form>
