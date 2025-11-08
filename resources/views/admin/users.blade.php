{{-- Admin Users Template --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'User Management'">
@php
    // Ensure $pendingUsers is always defined to avoid errors if not passed from controller
    if (!isset($pendingUsers)) {
        $pendingUsers = collect();
    }
@endphp
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                    <p class="text-sm text-gray-600">Manage system users and their permissions</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Add User form --}}
            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New User</h2>
                <form method="POST" action="{{ route('admin.users.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @csrf
                    <input name="name" class="md:col-span-2 rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Full Name" required>
                    <input name="email" type="email" class="md:col-span-2 rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Email" required autocomplete="email">
                    <select name="role" class="rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                        <option value="">Select Role</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="handler">Handler/Staff</option>
                        <option value="auditor">Auditor</option>
                    </select>
                    <input name="nickname" class="md:col-span-5 rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nickname (optional)">
                    <input name="password" type="password" class="md:col-span-2 rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Password" required autocomplete="new-password">
                    <input name="password_confirmation" type="password" class="md:col-span-2 rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Confirm Password" required autocomplete="new-password">
                    <div class="md:col-span-5 flex justify-end">
                        <button class="inline-flex items-center px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add User
                        </button>
                    </div>
                </form>
            </div>

            {{-- Users table --}}
            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
                    <span class="text-sm text-gray-500">{{ $users->total() }} users</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name / Nickname</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Registered</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Last Login</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Last Dashboard</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($users->filter(fn($u) => $u->status === 'registered') as $u)
                                @php($p = $profiles[$u->id] ?? null)
                                @php($lastLoginAt = $lastLogin[$u->id] ?? null)
                                @php($dash = $dashAgg[$u->id] ?? null)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900">{{ $p->nickname ?? $u->name }}</div>
                                        @if($p && $p->nickname)
                                            <div class="text-xs text-gray-500">{{ $u->name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $u->email }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->format('M d, Y') : '—' }}</td>
                                    <td class="px-4 py-3">
                                        @if($u->role==='admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Admin</span>
                                        @elseif($u->role==='handler')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Handler</span>
                                        @elseif($u->role==='auditor')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Auditor</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">User</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $lastLoginAt ? \Carbon\Carbon::parse($lastLoginAt)->diffForHumans() : '—' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $dash?->at ? \Carbon\Carbon::parse($dash->at)->diffForHumans() : '—' }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">{{ $dash?->cnt ?? 0 }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.users.show', $u->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">View</a>
                                        <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" class="inline ml-2" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>

            {{-- Pending Approval Users table --}}
            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5 mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">User Pending Approval</h2>
                    <span class="text-sm text-gray-500">{{ $pendingUsers->filter(fn($user) => $user->status === 'pending')->count() }} pending</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Registered</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($pendingUsers as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        @if($user->role==='admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Admin</span>
                                        @elseif($user->role==='handler')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Handler</span>
                                        @elseif($user->role==='auditor')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Auditor</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">User</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : '—' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($user->status === 'registered')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Registered</span>
                                        @elseif($user->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">{{ ucfirst($user->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-emerald-500 text-white rounded hover:bg-emerald-600 text-xs">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" class="inline ml-2">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No pending users.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div> {{-- /.flex-1 --}}
    </div> {{-- /.container --}}
    </x-layouts.app>