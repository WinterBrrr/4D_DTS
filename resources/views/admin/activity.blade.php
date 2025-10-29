@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush

<x-layouts.app :title="'Activity Logs'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.admin-sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Activity Logs</h1>
                    <p class="text-sm text-gray-600">System activity and user actions</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Back to Dashboard</a>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Time</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Details</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900 font-medium">{{ $log->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($log->user)
                                            <div class="font-semibold text-gray-900 text-sm">{{ $log->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $log->user->email }}</div>
                                        @else
                                            <span class="text-sm text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                            @if(str_contains($log->action, 'login')) bg-blue-100 text-blue-700
                                            @elseif(str_contains($log->action, 'profile')) bg-green-100 text-green-700
                                            @elseif(str_contains($log->action, 'admin')) bg-purple-100 text-purple-700
                                            @elseif(str_contains($log->action, 'dashboard')) bg-gray-100 text-gray-700
                                            @else bg-gray-100 text-gray-700
                                            @endif">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($log->details && is_array($log->details) && count($log->details) > 0)
                                            <div class="text-xs text-gray-600 space-y-0.5">
                                                @foreach($log->details as $key => $value)
                                                    <div><span class="font-medium text-gray-700">{{ $key }}:</span> {{ is_string($value) ? $value : json_encode($value) }}</div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 text-xs font-mono text-gray-600">{{ $log->ip ?? '—' }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="mt-2 text-sm font-medium text-gray-900">No activity logs found</p>
                                        <p class="mt-1 text-sm text-gray-500">Activity will appear here as users interact with the system</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-layouts.app>
