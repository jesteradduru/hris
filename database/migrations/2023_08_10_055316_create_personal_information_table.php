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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users');

            $table->string('employee_id')->nullable();
            $table->string('surname', 255);
            $table->string('first_name', 255);
            $table->string('name_extension', 255)->nullable();
            $table->string('middle_name', 255);
            $table->date('date_of_birth');
            $table->string('place_of_birth', 255);
            $table->string('sex', 255);
            $table->string('civil_status', 255);
            $table->string('other_civil_status', 255)->nullable();
            $table->string('filipino', 255);
            $table->string('height', 255);
            $table->string('weight', 255);
            $table->string('blood_type', 255);
            $table->string('gsis_id_number', 255)->nullable();
            $table->string('pagibig_id_number', 255)->nullable();
            $table->string('philhealth_number', 255)->nullable();
            $table->string('sss_number', 255)->nullable();
            $table->string('tin_number', 255)->nullable();
            $table->string('agency_employee_number', 255)->nullable();
            $table->string('citizenship', 255)->nullable();
            $table->boolean('dual_citizenship')->default(false);
            $table->boolean('by_naturalization')->default(false);
            $table->boolean('by_birth')->default(false);
            $table->string('country', 255)->nullable();
            $table->boolean('same_address')->default(false);
            $table->string('r_address_house_block_lot_number', 255)->nullable();
            $table->string('r_address_street', 255)->nullable();
            $table->string('r_address_subdivision_village', 255)->nullable();
            $table->string('r_address_barangay', 255)->nullable();
            $table->string('r_address_city_municipality', 255)->nullable();
            $table->string('r_address_province', 255)->nullable();
            $table->string('r_address_zipcode', 255)->nullable();
            $table->string('p_address_house_block_lot_number', 255)->nullable();
            $table->string('p_address_street', 255)->nullable();
            $table->string('p_address_subdivision_village', 255)->nullable();
            $table->string('p_address_barangay', 255)->nullable();
            $table->string('p_address_city_municipality', 255)->nullable();
            $table->string('p_address_province', 255)->nullable();
            $table->string('p_address_zipcode', 255)->nullable();
            $table->string('telephone_number', 255)->nullable();
            $table->string('mobile_number', 255)->nullable();
            $table->string('email_address', 255)->nullable();
            $table->string('religion', 255)->nullable();
            $table->string('ethnicity', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
