<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('background_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_class');
            $table->text('payload');
            $table->string('status')->default('pending'); // pending, running, completed, failed
            $table->integer('attempts')->default(0);
            $table->integer('max_attempts');
            $table->integer('priority')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'priority', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('background_jobs');
    }
}; 