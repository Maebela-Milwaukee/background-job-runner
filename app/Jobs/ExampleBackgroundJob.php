<?php

namespace App\Jobs;

class ExampleBackgroundJob extends BackgroundJob
{
    private $data;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
    }

    public function handle()
    {
        // Your job logic here
        logger()->info('Processing data:', $this->data);
        sleep(5); // Simulate some work
        logger()->info('Data processed successfully');
    }
} 