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
        Schema::create('psb_points', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(JobApplication::class, 'job_application_id')->constrained('job_applications');

            $table->decimal('performance');
            $table->decimal('experience');
            $table->decimal('org_competency');
            $table->decimal('leadership_competency');
            $table->decimal('technical_competency');
            $table->decimal('personality_peer')->nullable();
            $table->decimal('potential');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_points');
    }
};
