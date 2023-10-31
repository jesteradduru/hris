<?php

use App\Models\LndForm;
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
        Schema::create('idp_accomplishments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(LndForm::class, 'lnd_form_id')->constrained('lnd_forms');
            $table->text('activity');
            $table->text('filepath')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idp_accomplishments');
    }
};
