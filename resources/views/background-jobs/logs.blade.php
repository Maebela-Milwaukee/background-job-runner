<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Background Jobs Logs</h2>
                        <a href="{{ route('background-jobs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Job Logs</h3>
                        <pre class="bg-gray-50 p-4 rounded overflow-auto max-h-96">{{ $jobLogs }}</pre>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-4">Error Logs</h3>
                        <pre class="bg-red-50 p-4 rounded overflow-auto max-h-96 text-red-600">{{ $errorLogs }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 