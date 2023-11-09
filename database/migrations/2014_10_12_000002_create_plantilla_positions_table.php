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

            $table->string('title', 255);
            $table->string('item', 255)->unique();
            $table->integer('years_of_experience')->nullable();
            $table->decimal('hours_of_training')->nullable();
            $table->enum('education', ['MASTERS_DEGREE', 'BACHELORS_DEGREE', 'HIGH_SCHOOL', 'ELEMENTARY'])->nullable();
            $table->foreignIdFor(Division::class, 'division_id')->constrained('divisions');
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
