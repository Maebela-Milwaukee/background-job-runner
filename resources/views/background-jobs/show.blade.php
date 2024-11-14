<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Job Details</h2>
                        <a href="{{ route('background-jobs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <div class="bg-gray-50 p-4 rounded">
                                <h3 class="font-semibold text-lg mb-2">Basic Information</h3>
                                <dl class="grid grid-cols-3 gap-2">
                                    <dt class="font-medium">ID:</dt>
                                    <dd class="col-span-2">{{ $job->id }}</dd>
                                    
                                    <dt class="font-medium">Class:</dt>
                                    <dd class="col-span-2">{{ $job->job_class }}</dd>
                                    
                                    <dt class="font-medium">Status:</dt>
                                    <dd class="col-span-2">
                                        <span class="px-2 py-1 rounded text-sm
                                            @if($job->status === 'completed') bg-green-100
                                            @elseif($job->status === 'failed') bg-red-100
                                            @elseif($job->status === 'running') bg-yellow-100
                                            @else bg-blue-100
                                            @endif
                                        ">
                                            {{ $job->status }}
                                        </span>
                                    </dd>
                                    
                                    <dt class="font-medium">Priority:</dt>
                                    <dd class="col-span-2">{{ $job->priority }}</dd>
                                    
                                    <dt class="font-medium">Attempts:</dt>
                                    <dd class="col-span-2">{{ $job->attempts }}/{{ $job->max_attempts }}</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="bg-gray-50 p-4 rounded">
                                <h3 class="font-semibold text-lg mb-2">Timing Information</h3>
                                <dl class="grid grid-cols-3 gap-2">
                                    <dt class="font-medium">Created:</dt>
                                    <dd class="col-span-2">{{ $job->created_at->format('Y-m-d H:i:s') }}</dd>
                                    
                                    <dt class="font-medium">Scheduled:</dt>
                                    <dd class="col-span-2">{{ $job->scheduled_at?->format('Y-m-d H:i:s') ?? 'N/A' }}</dd>
                                    
                                    <dt class="font-medium">Started:</dt>
                                    <dd class="col-span-2">{{ $job->started_at?->format('Y-m-d H:i:s') ?? 'N/A' }}</dd>
                                    
                                    <dt class="font-medium">Completed:</dt>
                                    <dd class="col-span-2">{{ $job->completed_at?->format('Y-m-d H:i:s') ?? 'N/A' }}</dd>
                                </dl>
                            </div>
                        </div>

                        @if($job->error)
                        <div class="col-span-2">
                            <div class="bg-red-50 p-4 rounded">
                                <h3 class="font-semibold text-lg mb-2 text-red-700">Error Information</h3>
                                <pre class="whitespace-pre-wrap text-red-600">{{ $job->error }}</pre>
                            </div>
                        </div>
                        @endif

                        <div class="col-span-2 flex gap-2">
                            @if($job->status === 'running')
                            <form action="{{ route('background-jobs.cancel', $job) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel Job
                                </button>
                            </form>
                            @endif

                            @if($job->status === 'failed')
                            <form action="{{ route('background-jobs.retry', $job) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Retry Job
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 