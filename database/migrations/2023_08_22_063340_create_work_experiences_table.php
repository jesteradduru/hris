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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users');

            $table->date('inclusive_date_from')->nullable(); // pds inclusive dates & wes duration
            $table->string('inclusive_date_to', 255)->nullable(); // pds inclusive dates & wes duration
            $table->string('position_title', 255)->nullable(); // postion pds & wes
            $table->string('dept_agency_office_company', 255)->nullable(); // pds & wes
            $table->string('name_of_office_unit', 255)->nullable(); // wes
            $table->text('office_address', 255)->nullable(); // wes
            $table->string('immediate_supervisor', 255)->nullable(); // wes
            $table->decimal('monthly_salary',18,2)->default('0.00'); // pds
            $table->string('paygrade', 255)->nullable(); // pds
            $table->string('status_of_appointment', 255)->nullable(); // pds
            $table->boolean('to_present')->default(false);
            // $table->decimal('service_record_salary',18,2)->default('0.00');
            // $table->string('agency_type', 255)->nullable();
            // $table->string('pay', 255)->nullable();
            // $table->string('cause', 255)->nullable();
            $table->boolean('govt_service')->nullable();
            // $table->string('govt_service', 255)->nullable();
            $table->text('list_of_accomplishments')->nullable();
            $table->text('summary_of_duties')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
