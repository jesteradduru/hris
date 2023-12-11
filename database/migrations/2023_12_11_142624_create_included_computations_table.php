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
        Schema::create('included_computations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(JobApplication::class, 'job_application_id');
            $table->string('computable_type');
            $table->bigInteger('computable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('included_computations');
    }
};
