<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        'name' => fake()->company(),
        'room_number' => fake()->randomDigit(),
        'rate' => fake()->numberBetween(1000, 20000),
        'description' => fake()->paragraph(),
        'max_occupancy' => fake()->randomDigit(),
        'is_available' => fake()->numberBetween(0,1),
        'cover_image' => fake()->imageUrl(360, 360, 'hotels', true),
        'size' => fake()->numberBetween(50, 300),
        'floor' => fake()->numberBetween(1, 5),
        'beds' => fake()->numberBetween(1, 3),
      ];
    }
}
