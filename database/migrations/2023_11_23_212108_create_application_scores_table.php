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
            $table->decimal('education');
            $table->decimal('experience');
            $table->decimal('personality');
            $table->decimal('potential');
            $table->decimal('total');

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
