<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VoluntaryWork>
 */
class VoluntaryWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => 1,
            "name_address_of_org" => fake()->text(20),
            "inclusive_date_from" => fake()->date(),
            "inclusive_date_to" => fake()->date(),
            "number_of_hours" => fake()->randomDigit(),
            "position_work" => fake()->jobTitle(),
        ];
    }
}
