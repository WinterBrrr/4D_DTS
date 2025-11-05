{{-- Admin User Show --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'View User'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">User Profile</h1>
                    <p class="text-sm text-gray-600">View user details and account information</p>
                </div>
                <a href="{{ route('admin.users') }}" class="inline-flex items-center px-3 py-2 bg-emerald-600 rounded-lg text-white text-sm font-medium hover:bg-emerald-700">
                    Back to Users
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Profile Card --}}
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5">
                    @php($photo = $profile?->profile_photo_path)
                    <div class="flex flex-col items-center text-center">
                        <div class="relative rounded-full ring-4 ring-emerald-200 border-2 border-slate-300 shadow-md overflow-hidden flex-none" style="width:240px;height:240px;">
                            @if($photo)
                                <div id="profile-photo" class="absolute inset-0 w-full h-full"
                                     style="background: url('{{ asset('storage/'.$photo) }}?v={{ now()->timestamp }}') center 20% / cover no-repeat;">
                                </div>
                            @else
                                <div id="profile-initial" class="absolute inset-0 w-full h-full bg-emerald-600 text-white grid place-items-center text-5xl font-bold">
                                    {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 text-center">
                            <div class="text-xl font-semibold text-gray-900 leading-tight">{{ $profile->nickname ?? $user->name }}</div>
                            <div class="text-sm text-gray-500 mt-0.5 break-all">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="mt-6 text-sm space-y-2">
                        <div class="grid grid-cols-3 items-center">
                            <span class="text-gray-500 col-span-1">Role</span>
                            <div class="col-span-2 text-right">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $user->role==='admin' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <span class="text-gray-500 col-span-1">Status</span>
                            <div class="col-span-2 text-right">
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">{{ ucfirst($user->status ?? 'active') }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <span class="text-gray-500 col-span-1">Registered</span>
                            <div class="col-span-2 text-right">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Profile Details --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->nickname ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Identity</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->identity ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $user->name }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $user->email }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->age ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->occupation ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->nationality ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->contact_number ?? '—' }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->address ?? '—' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <div class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-gray-50">{{ $profile->gender ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
