<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            "inclusive_date_from" => fake()->date(),
            "inclusive_date_to" => fake()->date(),
            "position_title"  => fake()->jobTitle(),
            "dept_agency_office_company" => fake()->company(),
            "name_of_office_unit" => fake()->company(),
            "office_address" => fake()->address(),
            "immediate_supervisor" => fake()->name(),
            "monthly_salary" => fake()->numberBetween(2000, 5000),
            "paygrade" => fake()->numberBetween(),
            "status_of_appointment" => fake()->randomElement(['PERMANENT', 'COS', 'CASUAL']),
            "govt_service"=> fake()->boolean(),
            "list_of_accomplishments" => fake()->text(10),
            "summary_of_duties" => fake()->text(10),
            'to_present' => fake()->boolean(),
            'user_id' => 1,
        ];
    }
}
