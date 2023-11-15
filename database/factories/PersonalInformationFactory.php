<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalInformation>
 */
class PersonalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "surname" => fake()->lastName(),
            "first_name" => fake()->firstName(),
            "middle_name" => fake()->lastName(),
            "name_extension" => '',
            "date_of_birth" => fake()->date(),
            "place_of_birth" => fake()->city(),
            "sex" => 'MALE',
            "height" => '100',
            "weight" => '100',
            "blood_type" => 'O',
            "gsis_id_number" => fake()->numberBetween(10000, 50000),
            "pagibig_id_number" => fake()->numberBetween(10000, 50000),
            "sss_number" => fake()->numberBetween(10000, 50000),
            "philhealth_number" => fake()->numberBetween(10000, 50000),
            "tin_number" => fake()->numberBetween(10000, 50000),
            "agency_employee_number" => fake()->numberBetween(10000, 50000),
            "r_address_house_block_lot_number" => fake()->numberBetween(20, 99),
            "r_address_street" => fake()->streetAddress(),
            "r_address_subdivision_village" => '',
            "r_address_barangay" => fake()->city(),
            "r_address_city_municipality" => fake()->city(),
            "r_address_zipcode" => fake()->numberBetween(1000, 5000),
            "r_address_province" => fake()->city(),
            "telephone_number" => fake()->phoneNumber(),
            "mobile_number" => fake()->phoneNumber(),
            "email_address" => fake()->email(),
            "civil_status" => 'SINGLE',
            "country" => fake()->country(),
            "same_address" => 1,
        ];
    }
}
