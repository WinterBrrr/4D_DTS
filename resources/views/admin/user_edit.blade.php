{{-- Admin User Edit --}}
<x-layouts.app :title="'Edit User'">
    <div class="mx-auto w-full max-w-2xl px-4 py-8">
        <a href="{{ route('admin.users') }}" class="text-emerald-600 hover:underline">&larr; Back to Users</a>
        <div class="bg-white rounded-xl shadow p-6 mt-4">
            <h1 class="text-2xl font-bold mb-2">Edit User</h1>
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input name="name" value="{{ $user->name }}" class="w-full rounded border-gray-300 px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input name="email" type="email" value="{{ $user->email }}" class="w-full rounded border-gray-300 px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Role</label>
                    <select name="role" class="w-full rounded border-gray-300 px-3 py-2">
                        <option value="user" @if($user->role==='user') selected @endif>User</option>
                        <option value="admin" @if($user->role==='admin') selected @endif>Admin</option>
                        <option value="handler" @if($user->role==='handler') selected @endif>Handler</option>
                        <option value="auditor" @if($user->role==='auditor') selected @endif>Auditor</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Nickname</label>
                    <input name="nickname" value="{{ $profile->nickname ?? '' }}" class="w-full rounded border-gray-300 px-3 py-2">
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Save</button>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
