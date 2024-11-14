<?php

if (!function_exists('runBackgroundJob')) {
    function runBackgroundJob(App\Jobs\BackgroundJob $job): void
    {
        app(App\Services\BackgroundJobRunner::class)->dispatch($job);
    }
} 