{{-- Handler Forward Form --}}
<form method="POST" action="{{ route('handler.documents.forward', $doc->id) }}" class="mb-4">
    @csrf
    <label class="block text-sm font-medium text-gray-700 mb-2">Forward to Next Handler</label>
    <input type="text" name="next_handler" class="w-full rounded border-gray-300 mb-2" placeholder="Next Handler Name" required>
    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded">Forward</button>
</form>
