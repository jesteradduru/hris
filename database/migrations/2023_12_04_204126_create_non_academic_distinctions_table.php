<?php

use App\Models\RewardAndRecognition;
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
        Schema::create('non_academic_distinctions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(User::class, 'user_id')->constrained('users');
            $table->foreignIdFor(RewardAndRecognition::class, 'reward_id')->nullable();

            $table->string('others');

            $table->enum('category', [
                'MAJOR_NATIONAL',
                'MAJOR_LOCAL',
            ])->nullable();

            $table->enum('category_type', [
                'MAJOR',
                'MINOR',
            ])->nullable();

            $table->decimal('points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_academic_distinctions');
    }
};
