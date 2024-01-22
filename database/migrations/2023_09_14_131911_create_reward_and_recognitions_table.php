<?php

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
        Schema::create('reward_and_recognitions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->enum('category', [
                'MAJOR_LOCAL',
                'MINOR',
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_and_recognitions');
    }
};
