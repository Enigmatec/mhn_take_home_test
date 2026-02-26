<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disease>
 */
class DiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'category' => fake()->word(),
            'cat_id' => fake()->word(),
            'grade_code' => fake()->word(),
            'disease_code' => fake()->isbn13(),
        ];
    }
}
