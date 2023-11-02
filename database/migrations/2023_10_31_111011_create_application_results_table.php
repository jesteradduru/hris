<?php

use App\Models\JobApplication;
use App\Models\JobApplicationResults;
use App\Models\User;
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
        Schema::create('application_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(JobApplicationResults::class, 'result_id')->constrained('job_application_results');
            $table->boolean('published')->default(false);
            $table->text('notes')->nullable();
            $table->foreignIdFor(JobApplication::class, 'application_id')->constrained('job_applications');
            $table->foreignIdFor(User::class, 'user_id')->constrained('users');
            $table->enum('result', [
                'QUALIFIED',
                'UNQUALIFIED',
                'FOR_EXAM',
                'EXAM_PASSED',
                'EXAM_FAILED',
                'FOR_INTERVIEW',
                'SELECTED',
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_results');
    }
};
