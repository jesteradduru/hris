<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'username' => fake()->userName(),
            'dtr_user_id' => 3,
            'password' => '12341234',
            'plantilla_id' => null
        ];
    }
}
