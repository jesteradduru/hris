<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NonAcademicDistinction>
 */
class NonAcademicDistinctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 3,
            'points' => fake()->randomDigit(),
            'title' => fake()->text(10),
            'office' => fake()->company(),
            'date_awarded' => fake()->date(),
        ];
    }
}
