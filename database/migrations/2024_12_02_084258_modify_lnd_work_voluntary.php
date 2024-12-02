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
        Schema::table('learning_and_development', function (Blueprint $table) {
            $table->text('title_of_learning')->change()->nullable();
        });
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->text('position_title')->change()->nullable();
            $table->text('dept_agency_office_company')->change()->nullable();
            $table->text('name_of_office_unit')->change()->nullable();
        });
        Schema::table('voluntary_works', function (Blueprint $table) {
            $table->text('name_address_of_org')->change()->nullable();
            $table->text('position_work')->change()->nullable();
        });
    }
};
