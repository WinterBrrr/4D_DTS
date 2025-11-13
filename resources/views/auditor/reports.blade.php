{{-- Auditor Reports Template --}}
<x-layouts.app :title="'Auditor Reports'" compact-sidebar>
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.auditor-sidebar')
        
        <div class="flex-1">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
                <p class="text-sm text-gray-600">Monitor document processing performance and generate insights</p>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Documents</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totals['documents'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Avg Process Time</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totals['avg_process_time_days'] ?? 0 }} days</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totals['month_change'] ?? '0%' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Users</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $totals['active_users'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Report Filters --}}
            <div class="bg-white rounded-xl p-4 shadow-sm ring-1 ring-black/5 mb-6">
                <form method="GET" action="{{ route('auditor.reports') }}" class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2">
                        <label for="date_range" class="text-sm font-medium text-gray-700">Date Range:</label>
                        <select 
                            id="date_range" 
                            name="date_range"
                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                        >
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                <option value="3" {{ request('date_range') == '3' ? 'selected' : '' }}>Last 3 days</option>
                                <option value="7" {{ request('date_range') == '7' ? 'selected' : '' }}>Last 7 days</option>
                                <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>Last 30 days</option>
                                <option value="365" {{ request('date_range') == '365' ? 'selected' : '' }}>Last Year</option>
                                <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>Custom range</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="department_filter" class="text-sm font-medium text-gray-700">Department:</label>
                        <select 
                            id="department_filter" 
                            name="department_filter"
                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                        >
                            <option value="" {{ request('department_filter') == '' ? 'selected' : '' }}>All Departments</option>
                            <option value="CIT" {{ request('department_filter') == 'CIT' ? 'selected' : '' }}>CIT</option>
                            <option value="ICJE" {{ request('department_filter') == 'ICJE' ? 'selected' : '' }}>ICJE</option>
                            <option value="CE" {{ request('department_filter') == 'CE' ? 'selected' : '' }}>CE</option>
                            <option value="COE" {{ request('department_filter') == 'COE' ? 'selected' : '' }}>COE</option>
                            <option value="COM" {{ request('department_filter') == 'COM' ? 'selected' : '' }}>COM</option>
                            <option value="COT" {{ request('department_filter') == 'COT' ? 'selected' : '' }}>COT</option>
                            <option value="CAS" {{ request('department_filter') == 'CAS' ? 'selected' : '' }}>CAS</option>
                            <option value="ADMIN" {{ request('department_filter') == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                        </select>
                    </div>
                    <div class="ml-auto flex items-center gap-3">
                        <a href="{{ route('auditor.reports') }}" class="text-sm text-gray-600 hover:underline">Reset</a>
                        <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-emerald-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>

            {{-- Report Sections --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Document Status Chart --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Document Status Distribution</h3>
                    @if(!empty($statusCounts))
                        <div class="space-y-3">
                            @foreach($statusCounts as $label => $count)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @php
                                            $color = $colors[$label] ?? '#e5e7eb';
                                            $border = '';
                                            if ($label === 'Approved') {
                                                $color = '#22c55e'; // green
                                                $border = 'border border-green-500';
                                            } elseif ($label === 'Rejected') {
                                                $color = '#ef4444'; // red
                                                $border = 'border border-red-500';
                                            } elseif ($label === 'Pending') {
                                                $color = '#eab308'; // yellow
                                                $border = 'border border-yellow-500';
                                            } elseif ($label === 'Under Review') {
                                                $color = '#3b82f6'; // blue
                                                $border = 'border border-blue-500';
                                            } elseif ($label === 'Final Processing') {
                                                $color = '#a855f7'; // purple
                                                $border = 'border border-purple-500';
                                            } elseif ($label === 'Completed') {
                                                $color = '#22c55e'; // green
                                                $border = 'border border-green-500';
                                            }
                                        @endphp
                                        <div class="w-4 h-4 rounded mr-3 {{ $border }}" style="background-color: {{ $color }}"></div>
                                        <span class="text-sm text-gray-700">{{ $label }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-sm text-gray-500">No data to display.</div>
                    @endif
                </div>

                {{-- Department Breakdown --}}
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documents by Department</h3>
                    @if(!empty($departmentCounts))
                        <div class="space-y-3">
                            @foreach($departmentCounts as $dept => $count)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700">{{ $dept }}</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-sm text-gray-500">No data to display.</div>
                    @endif
                </div>
            </div>

            {{-- Recent Activity Table --}}
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Processing Activity</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Processed By</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse(($recent ?? []) as $row)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row['title'] ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['department'] ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $row['status'] ?? '' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['updated'] ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row['user'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No activity found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
