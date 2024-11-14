<?php

return [
    // Allowed job classes that can be executed in background
    'allowed_jobs' => [
        // Add your job classes here
        'App\\Jobs\\*',
    ],

    // Maximum retry attempts for failed jobs
    'max_retries' => 3,

    // Retry delay in seconds
    'retry_delay' => 60,

    // Path for job logs
    'log_path' => storage_path('logs/background-jobs.log'),
    
    // Path for error logs
    'error_log_path' => storage_path('logs/background-jobs-errors.log'),

    // Enable job priority (optional)
    'enable_priority' => true,

    // Default priority (higher number = higher priority)
    'default_priority' => 0,

    // PHP binary path (leave null for auto-detection)
    'php_binary' => null,
]; 