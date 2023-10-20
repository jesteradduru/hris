<?php

use App\Models\LndMonitoringReport;
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
        Schema::create('lnd_targetted_staff', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(User::class, 'user_id')->constrained('users');
            $table->foreignIdFor(LndMonitoringReport::class, 'report_id')->constrained('lnd_monitoring_reports');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lnd_targetted_staff');
    }
};
