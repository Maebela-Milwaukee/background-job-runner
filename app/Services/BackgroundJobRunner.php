<?php

namespace App\Services;

use App\Jobs\BackgroundJob;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use App\Models\BackgroundJobRecord;

class BackgroundJobRunner
{
    protected function validateJob(string $jobClass): void
    {
        if (!class_exists($jobClass)) {
            throw new RuntimeException("Job class {$jobClass} does not exist");
        }

        $allowedJobs = config('background-jobs.allowed_jobs', []);
        $isAllowed = false;

        foreach ($allowedJobs as $pattern) {
            if (fnmatch($pattern, $jobClass)) {
                $isAllowed = true;
                break;
            }
        }

        if (!$isAllowed) {
            throw new RuntimeException("Job class {$jobClass} is not allowed to run in background");
        }
    }

    public function dispatch(BackgroundJob $job): void
    {
        $jobClass = get_class($job);
        $this->validateJob($jobClass);

        // Create job record
        $jobRecord = BackgroundJobRecord::create([
            'job_class' => $jobClass,
            'payload' => base64_encode(serialize($job)),
            'status' => 'pending',
            'attempts' => 0,
            'max_attempts' => $job->getMaxAttempts(),
            'priority' => $job->getPriority(),
            'scheduled_at' => $job->getScheduledAt(),
        ]);

        if ($job->getDelay() > 0) {
            // Schedule delayed job
            $this->scheduleDelayedJob($jobRecord);
            return;
        }

        $this->runJob($jobRecord);
    }

    protected function runJob(BackgroundJobRecord $jobRecord): void
    {
        $phpBinary = config('background-jobs.php_binary') ?? PHP_BINARY;
        $artisanPath = base_path('artisan');

        $command = sprintf(
            '%s %s background-job:run %s > /dev/null 2>&1 &',
            escapeshellarg($phpBinary),
            escapeshellarg($artisanPath),
            escapeshellarg($jobRecord->id)
        );

        if (PHP_OS_FAMILY === 'Windows') {
            pclose(popen('start /B ' . $command, 'r'));
        } else {
            exec($command);
        }

        Log::channel('background-jobs')->info("Dispatched job: {$jobRecord->job_class}");
    }

    protected function scheduleDelayedJob(BackgroundJobRecord $jobRecord): void
    {
        Log::channel('background-jobs')->info(
            "Scheduled job: {$jobRecord->job_class} at {$jobRecord->scheduled_at}"
        );
    }
} 