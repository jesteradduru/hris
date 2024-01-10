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
        Schema::create('family_background', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id');

            $table->string('spouse_surname', 255)->nullable();
            $table->string('spouse_first_name', 255)->nullable();
            $table->string('spouse_name_extension', 255)->nullable();
            $table->string('spouse_middle_name', 255)->nullable();
            $table->string('spouse_occupation', 255)->nullable();
            $table->string('spouse_employer_business_name', 255)->nullable();
            $table->string('spouse_business_address', 255)->nullable();
            $table->string('spouse_telephone_number', 255)->nullable();
            $table->boolean('spouse_deceased')->default(false)->nullable();
            $table->string('fathers_surname', 255);
            $table->string('fathers_first_name', 255);
            $table->string('fathers_name_extension', 255)->nullable();
            $table->string('fathers_middle_name', 255);
            $table->boolean('fathers_deceased')->default(false)->nullable();
            $table->string('mothers_surname', 255);
            $table->string('mothers_first_name', 255);
            $table->string('mothers_middle_name', 255);
            $table->boolean('mothers_deceased')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_background');
    }
};
