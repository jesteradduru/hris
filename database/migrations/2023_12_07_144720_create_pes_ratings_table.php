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
        Schema::create('pes_ratings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(JobApplication::class, 'application_id')->constrained('job_applications');
            $table->decimal('first_rating');
            $table->decimal('second_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pes_ratings');
    }
};
