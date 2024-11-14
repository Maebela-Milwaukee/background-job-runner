<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BackgroundJobDashboardController;
use Illuminate\Support\Facades\Route;

// Redirect root to background jobs dashboard
Route::redirect('/', '/background-jobs');

Route::middleware(['auth'])->group(function () {
    // Background Jobs Dashboard Routes
    Route::get('/background-jobs', [BackgroundJobDashboardController::class, 'index'])
        ->name('background-jobs.index');
    Route::get('/background-jobs/{job}', [BackgroundJobDashboardController::class, 'show'])
        ->name('background-jobs.show');
    Route::post('/background-jobs/{job}/cancel', [BackgroundJobDashboardController::class, 'cancel'])
        ->name('background-jobs.cancel');
    Route::post('/background-jobs/{job}/retry', [BackgroundJobDashboardController::class, 'retry'])
        ->name('background-jobs.retry');
    Route::get('/background-jobs-logs', [BackgroundJobDashboardController::class, 'logs'])
        ->name('background-jobs.logs');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
