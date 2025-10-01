<?php

namespace Database\Factories;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var class-string<\Illuminate\Database\Eloquent\Model>
   */
  protected $model = InventoryItem::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
      return [
        'name' => fake()->words(5, true),
        'description' => fake()->text(),
        'unit' => fake()->randomElement(['KG', 'PCS', 'BOX']),
        'stock' => fake()->numberBetween(0, 250),
        'min_level' => fake()->numberBetween(10,50),
        'refill_quantity' => fake()->numberBetween(10,50),
        'est_cost' => fake()->randomFloat(2, 10, 1000),
        'inventory_category_id' => InventoryCategory::inRandomOrder()->first()->id,
      ];
  }
}
