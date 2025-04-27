<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->realText(rand(10, 20)),
            'description' => fake()->sentence(),
            //'status_id' => fake()->biasedNumberBetween(1, 1000),
            //'created_by_id' => fake()->biasedNumberBetween(1, 1000),
            'assigned_to_id' => null,
        ];
    }
}

