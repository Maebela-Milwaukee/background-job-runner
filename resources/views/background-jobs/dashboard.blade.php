<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Background Jobs Dashboard</h2>

                    <!-- Stats -->
                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded">
                            <div class="text-xl">{{ $stats['pending'] }}</div>
                            <div class="text-sm">Pending</div>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded">
                            <div class="text-xl">{{ $stats['running'] }}</div>
                            <div class="text-sm">Running</div>
                        </div>
                        <div class="bg-green-100 p-4 rounded">
                            <div class="text-xl">{{ $stats['completed'] }}</div>
                            <div class="text-sm">Completed</div>
                        </div>
                        <div class="bg-red-100 p-4 rounded">
                            <div class="text-xl">{{ $stats['failed'] }}</div>
                            <div class="text-sm">Failed</div>
                        </div>
                    </div>

                    <!-- Jobs Table -->
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b">ID</th>
                                <th class="px-6 py-3 border-b">Job</th>
                                <th class="px-6 py-3 border-b">Status</th>
                                <th class="px-6 py-3 border-b">Priority</th>
                                <th class="px-6 py-3 border-b">Attempts</th>
                                <th class="px-6 py-3 border-b">Scheduled</th>
                                <th class="px-6 py-3 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                            <tr>
                                <td class="px-6 py-4 border-b">{{ $job->id }}</td>
                                <td class="px-6 py-4 border-b">{{ $job->job_class }}</td>
                                <td class="px-6 py-4 border-b">
                                    <span class="px-2 py-1 rounded text-sm
                                        @if($job->status === 'completed') bg-green-100
                                        @elseif($job->status === 'failed') bg-red-100
                                        @elseif($job->status === 'running') bg-yellow-100
                                        @else bg-blue-100
                                        @endif
                                    ">
                                        {{ $job->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 border-b">{{ $job->priority }}</td>
                                <td class="px-6 py-4 border-b">{{ $job->attempts }}/{{ $job->max_attempts }}</td>
                                <td class="px-6 py-4 border-b">{{ $job->scheduled_at?->diffForHumans() }}</td>
                                <td class="px-6 py-4 border-b">
                                    <a href="{{ route('background-jobs.show', $job) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                    @if($job->status === 'running')
                                    <form action="{{ route('background-jobs.cancel', $job) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Cancel</button>
                                    </form>
                                    @endif
                                    @if($job->status === 'failed')
                                    <form action="{{ route('background-jobs.retry', $job) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800 ml-2">Retry</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 