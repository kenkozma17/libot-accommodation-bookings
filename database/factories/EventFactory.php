<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $guest = Guest::inRandomOrder()->first();
        return [
          'name' => fake()->words(2, true),
          'type' => fake()->randomElement(['Breakfast', 'Lunch', 'Dinner']),
          'pax' => fake()->numberBetween(0, 250),
          'setup_time' => fake()->time(),
          'start_time' => fake()->time(),
          'end_time' => fake()->time(),
          'serving_time' => fake()->time(),
          'start_date' => fake()->dateTimeThisMonth(),
          'end_date' => fake()->dateTimeThisMonth(),
          'status' => 'CONFIRMED',
          'guest_id' => $guest,
          'notes' => fake()->text(),
        ];
    }
}
