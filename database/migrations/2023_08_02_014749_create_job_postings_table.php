<?php

use App\Models\PlantillaPosition;
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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(User::class, 'by_user_id')->constrained('users');
            // $table->string('place_of_assignment')->nullable();
            // $table->string('position')->nullable();
            // $table->string('plantilla_item_no')->nullable();
            // $table->string('salary_grade')->nullable();
            // $table->string('monthly_salary')->nullable();
            // $table->string('eligibility')->nullable();
            // $table->string('education')->nullable();
            // $table->string('training')->nullable();
            // $table->string('work_experience')->nullable();
            // $table->string('competency')->nullable();
            $table->foreignIdFor(PlantillaPosition::class, 'plantilla_id')->constrained('plantilla_positions');
            $table->date('posting_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->text('documents')->nullable();
            $table->dateTime('archived_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
