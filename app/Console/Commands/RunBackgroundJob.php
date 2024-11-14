<?php

namespace App\Console\Commands;

use App\Jobs\BackgroundJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class RunBackgroundJob extends Command
{
    protected $signature = 'background-job:run {job}';
    protected $description = 'Run a background job';

    public function handle()
    {
        try {
            $serializedJob = base64_decode($this->argument('job'));
            /** @var BackgroundJob $job */
            $job = unserialize($serializedJob);

            if (!$job instanceof BackgroundJob) {
                throw new \RuntimeException('Invalid job type');
            }

            Log::channel('background-jobs')->info(sprintf(
                'Starting job: %s (Attempt: %d)',
                get_class($job),
                $job->getAttempts() + 1
            ));

            $job->incrementAttempts();
            $job->handle();

            Log::channel('background-jobs')->info(sprintf(
                'Completed job: %s',
                get_class($job)
            ));

        } catch (Throwable $e) {
            Log::channel('background-jobs-errors')->error(sprintf(
                'Job failed: %s. Error: %s',
                get_class($job ?? null),
                $e->getMessage()
            ));

            if (!isset($job) || $job->hasExceededMaxAttempts()) {
                return 1;
            }

            // Retry the job
            sleep(config('background-jobs.retry_delay', 60));
            app(BackgroundJobRunner::class)->dispatch($job);
        }

        return 0;
    }
} 