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
        Schema::create('timesheet_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('timesheet_id');
            $table->bigInteger('employee')->unsigned()->nullable();
            $table->enum('purpose', ['pass', 'supp', 'off'])->nullable();
            $table->enum('pass_type', ['official', 'personal'])->nullable();
            $table->date('date')->nullable();
            $table->time('pass_out')->nullable();
            $table->time('pass_in')->nullable();
            $table->time('supp_am_in')->nullable();
            $table->time('supp_am_out')->nullable();
            $table->time('supp_pm_in')->nullable();
            $table->time('supp_pm_out')->nullable();
            $table->string('off_title')->nullable();
            $table->integer('off_hours')->nullable();
            $table->string('eo_sched_type')->nullable();
            $table->time('eo_start')->nullable();
            $table->time('eo_end')->nullable();
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheet_entries');
    }
};
