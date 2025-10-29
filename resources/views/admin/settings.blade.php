{{-- Admin Settings Template --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Admin Settings'" :compactSidebar="true" :hideGlobalHeader="true">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        <div class="flex-1">

            <div class="space-y-6">
                {{-- General Settings --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">General Settings</h3>
                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="system_name" class="block text-sm font-medium text-gray-700 mb-2">System Name</label>
                                <input 
                                    type="text" 
                                    id="system_name" 
                                    name="system_name" 
                                    value="Document Management System"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                />
                            </div>
                            <div>
                                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Admin Email</label>
                                <input 
                                    type="email" 
                                    id="admin_email" 
                                    name="admin_email" 
                                    value="admin@example.com"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                />
                            </div>
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                                <select 
                                    id="timezone" 
                                    name="timezone"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                >
                                    <option value="UTC">UTC</option>
                                    <option value="America/New_York">Eastern Time</option>
                                    <option value="America/Chicago">Central Time</option>
                                    <option value="America/Denver">Mountain Time</option>
                                    <option value="America/Los_Angeles" selected>Pacific Time</option>
                                </select>
                            </div>
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Default Language</label>
                                <select 
                                    id="language" 
                                    name="language"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                >
                                    <option value="en" selected>English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                </select>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Save General Settings
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Document Settings --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Document Settings</h3>
                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="max_file_size" class="block text-sm font-medium text-gray-700 mb-2">Max File Size (MB)</label>
                                <input 
                                    type="number" 
                                    id="max_file_size" 
                                    name="max_file_size" 
                                    value="10"
                                    min="1"
                                    max="100"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                />
                            </div>
                            <div>
                                <label for="auto_archive_days" class="block text-sm font-medium text-gray-700 mb-2">Auto Archive After (Days)</label>
                                <input 
                                    type="number" 
                                    id="auto_archive_days" 
                                    name="auto_archive_days" 
                                    value="365"
                                    min="30"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Allowed File Types</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="file_types[]" value="pdf" checked class="rounded border-gray-300 text-emerald-600">
                                    <span class="ml-2 text-sm text-gray-700">PDF</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="file_types[]" value="doc" checked class="rounded border-gray-300 text-emerald-600">
                                    <span class="ml-2 text-sm text-gray-700">DOC</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="file_types[]" value="docx" checked class="rounded border-gray-300 text-emerald-600">
                                    <span class="ml-2 text-sm text-gray-700">DOCX</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="file_types[]" value="txt" checked class="rounded border-gray-300 text-emerald-600">
                                    <span class="ml-2 text-sm text-gray-700">TXT</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="file_types[]" value="xlsx" checked class="rounded border-gray-300 text-emerald-600">
                                    <span class="ml-2 text-sm text-gray-700">XLSX</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="file_types[]" value="pptx" checked class="rounded border-gray-300 text-emerald-600">
                                    <span class="ml-2 text-sm text-gray-700">PPTX</span>
                                </label>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Save Document Settings
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Security Settings --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Security Settings</h3>
                    
                    @if(session('success'))
                        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.settings.notifications') }}" class="space-y-4">
                        @csrf
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h4>
                                    <p class="text-sm text-gray-500">Require 2FA for admin accounts</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="two_factor_required" value="1" class="sr-only peer" {{ $settings['two_factor_required'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">SMS Notifications</h4>
                                    <p class="text-sm text-gray-500">Send SMS alerts for urgent documents</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="sms_notifications" value="1" class="sr-only peer" {{ $settings['sms_notifications'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Daily Summary Reports</h4>
                                    <p class="text-sm text-gray-500">Receive daily processing summary</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="daily_summary_reports" value="1" class="sr-only peer" {{ $settings['daily_summary_reports'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Save Notification Settings
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Setup 2FA</h4>
                                <p class="text-sm text-gray-500">Configure two-factor authentication for your account</p>
                            </div>
                            <a href="{{ route('admin.2fa.setup') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                Setup 2FA
                            </a>
                        </div>
                    </div>
                </div>

                {{-- System Maintenance --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Maintenance</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form method="POST" action="{{ route('admin.export.data') }}" class="inline">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Export Data
                                </button>
                            </form>
                            <a href="{{ route('admin.system.check') }}" class="flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-lg font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                System Check
                            </a>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Last backup:</span>
                                <span class="text-gray-900">2 hours ago</span>
                            </div>
                            <div class="flex items-center justify-between text-sm mt-2">
                                <span class="text-gray-500">System version:</span>
                                <span class="text-gray-900">1.2.3</span>
                            </div>
                            <div class="flex items-center justify-between text-sm mt-2">
                                <span class="text-gray-500">Database size:</span>
                                <span class="text-gray-900">245 MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>