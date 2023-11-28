<?php

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
        Schema::create('educational_background', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users');

            $table->string('elem_name_of_school', 255);
            $table->string('elem_basic_ed_degree_course', 255)->nullable();
            $table->string('elem_period_from', 255);
            $table->string('elem_period_to', 255);
            $table->string('elem_highest_lvl_units_earned', 255)->nullable();
            $table->integer('elem_year_graduated');
            $table->string('elem_scholarship_academic_honors', 255)->nullable();
            $table->string('second_name_of_school', 255);
            $table->string('second_basic_ed_degree_course', 255)->nullable();
            $table->string('second_period_from', 255);
            $table->string('second_period_to', 255);
            $table->string('second_highest_lvl_units_earned', 255)->nullable();
            $table->integer('second_year_graduated');
            $table->string('second_scholarship_academic_honors', 255)->nullable();
            $table->string('vocational_name_of_school', 255)->nullable();
            $table->string('vocational_basic_ed_degree_course', 255)->nullable();
            $table->string('vocational_period_from', 255)->nullable();
            $table->string('vocational_period_to', 255)->nullable();
            $table->string('vocational_highest_lvl_units_earned', 255)->nullable();
            $table->integer('vocational_year_graduated')->nullable();
            $table->string('vocational_scholarship_academic_honors', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_background');
    }
};
