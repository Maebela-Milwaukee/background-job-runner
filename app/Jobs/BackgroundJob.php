<?php

namespace App\Jobs;

abstract class BackgroundJob
{
    protected $attempts = 0;
    protected $maxAttempts;
    protected $priority;
    protected $delay = 0;
    protected $scheduledAt = null;

    public function __construct()
    {
        $this->maxAttempts = config('background-jobs.max_retries', 3);
        $this->priority = config('background-jobs.default_priority', 0);
    }

    abstract public function handle();

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setMaxAttempts(int $attempts): self
    {
        $this->maxAttempts = $attempts;
        return $this;
    }

    public function incrementAttempts(): void
    {
        $this->attempts++;
    }

    public function hasExceededMaxAttempts(): bool
    {
        return $this->attempts >= $this->maxAttempts;
    }

    public function delay(int $seconds): self
    {
        $this->delay = $seconds;
        $this->scheduledAt = now()->addSeconds($seconds);
        return $this;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function getScheduledAt(): ?\DateTime
    {
        return $this->scheduledAt;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }
} 