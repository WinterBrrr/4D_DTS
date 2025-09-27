{{-- Admin Settings Template --}}
<x-layouts.app :title="'Admin Settings'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')
        
        <div class="flex-1">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">System Settings</h1>
                <p class="text-sm text-gray-600">Configure system preferences and administrative options</p>
            </div>

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
                    <form class="space-y-4">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h4>
                                    <p class="text-sm text-gray-500">Require 2FA for admin accounts</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">SMS Notifications</h4>
                                    <p class="text-sm text-gray-500">Send SMS alerts for urgent documents</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Daily Summary Reports</h4>
                                    <p class="text-sm text-gray-500">Receive daily processing summary</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
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
                </div>

                {{-- System Maintenance --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Maintenance</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <button class="flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Export Data
                            </button>
                            <button class="flex items-center justify-center px-4 py-3 bg-yellow-600 border border-transparent rounded-lg font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Clear Cache
                            </button>
                            <button class="flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-lg font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                System Check
                            </button>
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
</x-layouts.app>focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Session Timeout</h4>
                                    <p class="text-sm text-gray-500">Automatically log out inactive users</p>
                                </div>
                                <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                    <option value="15">15 minutes</option>
                                    <option value="30" selected>30 minutes</option>
                                    <option value="60">1 hour</option>
                                    <option value="120">2 hours</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Login Attempts</h4>
                                    <p class="text-sm text-gray-500">Max failed login attempts before lockout</p>
                                </div>
                                <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                    <option value="3">3 attempts</option>
                                    <option value="5" selected>5 attempts</option>
                                    <option value="10">10 attempts</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Audit Logging</h4>
                                    <p class="text-sm text-gray-500">Log all admin actions</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                </label>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Save Security Settings
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notification Settings --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Settings</h3>
                    <form class="space-y-4">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                    <p class="text-sm text-gray-500">Send email alerts for document status changes</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-