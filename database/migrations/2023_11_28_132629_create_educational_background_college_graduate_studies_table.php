<?php

use App\Models\EducationalBackground;
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
        Schema::create('educational_background_college_graduate_studies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name_of_school', 255)->nullable();
            $table->string('basic_ed_degree_course', 255)->nullable();
            $table->string('period_from', 255)->nullable();
            $table->string('period_to', 255)->nullable();
            $table->string('highest_lvl_units_earned', 255)->nullable();
            $table->integer('year_graduated')->nullable();
            // $table->string('scholarship_academic_honors', 255)->nullable();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users');
            $table->enum('type', ['COLLEGE', 'GRADUATE', 'ELEMENTARY', 'SECONDARY', 'VOCATIONAL'])->nullable();
            $table->enum('level', ['DOCTORATE', 'MASTERAL', 'DIPLOMA', 'BACHEL0R', 'TWO_YEAR'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_background_college_graduate_studies');
    }
};
