<?php

use App\Models\LearningAndDevelopment;
use App\Models\LndForm;
use App\Models\LndTargettedStaff;
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
        Schema::create('lnd_trainings_attended', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(LearningAndDevelopment::class, 'training_id')->constrained('learning_and_development');
            $table->foreignIdFor(LndForm::class, 'lnd_form_id')->constrained('lnd_forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lnd_trainings_attended');
    }
};
