<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundJobRecord extends Model
{
    protected $table = 'background_jobs';

    protected $fillable = [
        'job_class',
        'payload',
        'status',
        'attempts',
        'max_attempts',
        'priority',
        'scheduled_at',
        'started_at',
        'completed_at',
        'error',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRunning($query)
    {
        return $query->where('status', 'running');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
} 