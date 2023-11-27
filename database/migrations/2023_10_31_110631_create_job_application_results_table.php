<?php

use App\Models\JobPosting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_application_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('phase', [
                'INITIAL_SCREENING',
                'SHORTLISTING',
                'NEDA_EXAM_SCHEDULE',
                'NEDA_EXAM',
                'INTERVIEW_SCHEDULE',
                'FOR_INTERVIEW',
                'INTERVIEW',
                'FINAL',
                'SELECTION',
            ]);
            $table->dateTime('schedule')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->foreignIdFor(JobPosting::class, 'job_posting_id')->constrained('job_postings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_application_results');
    }
};
