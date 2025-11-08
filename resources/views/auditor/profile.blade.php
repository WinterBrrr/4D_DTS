{{-- Auditor Profile Page --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Auditor Profile'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.auditor-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Your Profile</h1>
                    <p class="text-sm text-gray-600">Manage your personal information and account settings</p>
                </div>
                <a href="{{ route('auditor.dashboard') }}" class="inline-flex items-center px-3 py-2 bg-emerald-600 rounded-lg text-white text-sm font-medium hover:bg-emerald-700">
                    Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Profile Card --}}
                <div class="lg:col-span-1 bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5">
                    @php($pUser = \App\Models\User::where('email', Session::get('user_email'))->first())
                    @php($profile = $pUser ? \App\Models\UserProfile::where('user_id', $pUser->id)->first() : null)
                    <div class="flex flex-col items-center text-center">
                        @php($photo = session('profile_photo_path') ?: ($profile?->profile_photo_path))
                        <div class="relative rounded-full ring-4 ring-emerald-200 border-2 border-slate-300 shadow-md overflow-hidden flex-none" style="width:240px;height:240px;">
                            @if($photo)
                                <div id="profile-photo" class="absolute inset-0 w-full h-full"
                                     style="background: url('{{ asset('storage/'.$photo) }}?v={{ now()->timestamp }}') center 20% / cover no-repeat;">
                                </div>
                            @else
                                <div id="profile-initial" class="absolute inset-0 w-full h-full bg-emerald-600 text-white grid place-items-center text-5xl font-bold">
                                    {{ strtoupper(substr(Session::get('user_name', Session::get('user_email', 'U')), 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 text-center">
                            <div class="text-xl font-semibold text-gray-900 leading-tight">{{ $profile->nickname ?? ($pUser->name ?? Session::get('user_name', 'User')) }}</div>
                            <div class="text-sm text-gray-500 mt-0.5 break-all">{{ $pUser->email ?? Session::get('user_email', '') }}</div>
                        </div>
                    </div>

                    <div class="mt-6 text-sm space-y-2">
                        <div class="grid grid-cols-3 items-center">
                            <span class="text-gray-500 col-span-1">Role</span>
                            <div class="col-span-2 text-right">
                                @php($role = ucfirst(Session::get('user_role', 'auditor')))
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $role==='Admin' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">{{ $role }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <span class="text-gray-500 col-span-1">Status</span>
                            <div class="col-span-2 text-right">
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Active</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                            <div class="flex items-center gap-3">
                                <input id="photo-input" type="file" name="photo" accept="image/*" class="sr-only" />
                                <button type="button" id="photo-trigger" class="inline-flex items-center px-4 py-2 rounded-lg border border-emerald-200 text-emerald-700 bg-white hover:bg-emerald-50 shadow-sm text-sm">Choose Photo</button>
                                <span id="photo-filename" class="text-sm text-gray-600">No file chosen</span>
                            </div>
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 rounded-lg text-white text-sm font-medium hover:bg-emerald-700">Upload Photo</button>
                        </form>
                    </div>
                </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('photo-input');
        const trigger = document.getElementById('photo-trigger');
        const fileNameEl = document.getElementById('photo-filename');
        if (!input) return;

        // Nice file chooser UX
        if (trigger) {
            trigger.addEventListener('click', function(e){
                e.preventDefault();
                input.click();
            });
        }
        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            if (fileNameEl) {
                fileNameEl.textContent = file.name;
            }
            let el = document.getElementById('profile-photo');
            const initial = document.getElementById('profile-initial');

            if (el) {
                // If it's a div (background preview), update background-image
                if (el.tagName !== 'IMG') {
                    el.style.backgroundImage = `url('${url}')`;
                    el.classList.add('bg-cover','bg-center');
                } else {
                    // Legacy img fallback
                    el.src = url;
                    el.className = 'block h-full w-full object-cover object-center';
                }
            } else {
                // Create a background preview div if none exists yet
                const bg = document.createElement('div');
                bg.id = 'profile-photo';
                bg.className = 'h-full w-full bg-center bg-cover';
                bg.style.backgroundImage = `url('${url}')`;
                if (initial && initial.parentNode) {
                    initial.parentNode.insertBefore(bg, initial);
                    initial.remove();
                }
            }
        });
    });
</script>

                {{-- Profile Details / Forms --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-black/5">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-4" method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                                <input name="nickname" type="text" value="{{ $profile->nickname ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <input name="role" type="text" value="{{ ucfirst(Session::get('user_role', $pUser->role ?? 'Auditor')) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm bg-gray-100 cursor-not-allowed focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" readonly tabindex="-1" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input name="full_name" type="text" value="{{ $pUser->name ?? Session::get('user_name', 'Auditor') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input name="email" type="email" value="{{ $pUser->email ?? Session::get('user_email', '') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm bg-gray-100 cursor-not-allowed focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" readonly tabindex="-1" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                <input name="age" type="number" min="1" max="120" value="{{ $profile->age ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                <input name="occupation" type="text" value="{{ $profile->occupation ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                                <input name="nationality" type="text" value="{{ $profile->nationality ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                <input name="contact_number" type="text" value="{{ $profile->contact_number ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input name="address" type="text" value="{{ $profile->address ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                @php($gVal = $profile->gender ?? '')
                                <select name="gender" class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                    <option value="">Select...</option>
                                    <option value="Male" {{ $gVal==='Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $gVal==='Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-span-2 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-lg text-white text-sm font-medium hover:bg-emerald-700">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
