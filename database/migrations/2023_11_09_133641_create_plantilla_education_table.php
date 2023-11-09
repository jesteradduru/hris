<?php

use App\Models\PlantillaPosition;
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
        Schema::create('plantilla_education', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(PlantillaPosition::class, 'plantilla_id');
            $table->text('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_education');
    }
};
