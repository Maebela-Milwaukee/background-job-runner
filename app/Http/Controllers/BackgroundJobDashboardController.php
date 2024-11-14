<?php

namespace App\Http\Controllers;

use App\Models\BackgroundJobRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackgroundJobDashboardController extends Controller
{
    public function index()
    {
        $jobs = BackgroundJobRecord::latest()
            ->paginate(20);

        $stats = [
            'pending' => BackgroundJobRecord::pending()->count(),
            'running' => BackgroundJobRecord::running()->count(),
            'completed' => BackgroundJobRecord::completed()->count(),
            'failed' => BackgroundJobRecord::failed()->count(),
        ];

        return view('background-jobs.dashboard', compact('jobs', 'stats'));
    }

    public function show(BackgroundJobRecord $job)
    {
        return view('background-jobs.show', compact('job'));
    }

    public function cancel(BackgroundJobRecord $job)
    {
        if ($job->status === 'running') {
            // Implement job cancellation logic here
            $job->update(['status' => 'failed', 'error' => 'Job cancelled by user']);
        }

        return redirect()->back()->with('success', 'Job cancelled successfully');
    }

    public function retry(BackgroundJobRecord $job)
    {
        if ($job->status === 'failed') {
            $job->update(['status' => 'pending', 'attempts' => 0]);
            app(BackgroundJobRunner::class)->runJob($job);
        }

        return redirect()->back()->with('success', 'Job queued for retry');
    }

    public function logs()
    {
        $jobLogs = File::get(config('background-jobs.log_path'));
        $errorLogs = File::get(config('background-jobs.error_log_path'));

        return view('background-jobs.logs', compact('jobLogs', 'errorLogs'));
    }
} 