<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'trainingDate' => fake()->date(),
            'trainingStartTime' => fake()->time(),
            'trainingEndTime' => fake()->time(),
            'trainingParts' => json_encode(['chest' => '가슴', 'abs' => '복부']),
            'content' => fake()->text(),
        ];
    }
}
