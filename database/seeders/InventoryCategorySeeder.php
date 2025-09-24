<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InventoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
          "Housekeeping & Rooms",
          "Guest Amenities",
          "Food & Beverage",
          "Beach / Pool",
          "Office Supplies",
          "Maintenance",
          "Safety, Security & Emergency",
          "Uniforms & Staff Supplies",
          "Spa & Wellness",
          "Events",
          "Laundry Supplies"
        ];

        foreach($categories as $category) {
          $categoryExists = InventoryCategory::where('name', $category)->first();

          if(!$categoryExists) {
            $cat = new InventoryCategory;
            $cat->fill([
              'name' => $category,
              'slug' => Str::slug($category),
            ]);
            $cat->save();
          }
        }
    }
}
