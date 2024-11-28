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
        Schema::table('timesheet_entries', function (Blueprint $table) {
            $table->decimal('off_hours')->change()->nullable();
            // $table->addColumn('date', 'reg_start')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
};
