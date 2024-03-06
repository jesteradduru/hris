<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningAndDevelopment>
 */
class LearningAndDevelopmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title_of_learning' => fake()->text(5),
            'inclusive_date_from' => fake()->date(),
            'inclusive_date_to' => fake()->date(),
            'number_of_hours' => fake()->randomNumber(),
            'type_of_ld' => fake()->randomElement(['TECHNICAL', 'SUPERVISORY', 'MANAGERIAL']),
            'conducted_sponsored_by' => fake()->company(),
        ];
    }
}
