<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CivilServiceEligibility>
 */
class CivilServiceEligibilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "cs_board_bar_ces_csee_barangay_drivers" => fake()->text(20),
            "rating" => fake()->text(20),
            "date_of_exam_conferment" => fake()->date(),
            "place_of_exam_conferment" => fake()->city(),
            "license_number" => fake()->text(20),
            "license_date_of_validity" => fake()->date(),
        ];
    }
}
