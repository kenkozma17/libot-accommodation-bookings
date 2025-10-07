<?php

namespace Database\Seeders;

use App\Models\EventSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventSet::factory()
          ->count(25)
          ->create();
    }
}
