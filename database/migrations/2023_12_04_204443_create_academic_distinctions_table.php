<?php

use App\Models\EducationalBackgroundCollegeGraduateStudy;
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
        Schema::create('academic_distinctions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(EducationalBackgroundCollegeGraduateStudy::class, 'educ_id')->constrained('educational_background_college_graduate_studies');
            $table->string('title');

            $table->date('date_awarded')->nullable();

            $table->enum('category', [
                'LATIN',
                'SCHOLARSHIP',
                'SPECIAL',
            ])->nullable();
            
            $table->decimal('points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_distinctions');
    }
};
