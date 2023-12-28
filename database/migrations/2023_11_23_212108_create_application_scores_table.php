<?php

use App\Models\JobApplication;
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
        Schema::create('application_scores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->decimal('performance');
            $table->integer('performance_rank')->nullable();
            $table->decimal('education');
            $table->integer('education_rank')->nullable();
            $table->decimal('experience');
            $table->integer('experience_rank')->nullable();
            $table->decimal('personality');
            $table->integer('personality_rank')->nullable();
            $table->decimal('potential');
            $table->integer('potential_rank')->nullable();
            $table->decimal('total');
            $table->integer('total_rank')->nullable();

            $table->foreignIdFor(JobApplication::class, 'job_application_id')->constrained('job_applications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_scores');
    }
};
