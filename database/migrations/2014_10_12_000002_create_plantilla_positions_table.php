<?php

use App\Models\Division;
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
        Schema::create('plantilla_positions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('place_of_assignment')->nullable();
            $table->string('position')->nullable();
            $table->string('plantilla_item_no')->nullable()->unique();
            $table->string('salary_grade')->nullable();
            $table->string('monthly_salary')->nullable();
            $table->string('eligibility')->nullable();
            $table->string('education')->nullable();
            $table->integer('training')->nullable();
            $table->integer('work_experience')->nullable();
            $table->text('competency')->nullable();
            $table->foreignIdFor(Division::class, 'division_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_positions');
    }
};
