<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Initialize Faker library
        $faker = Faker::create();

        // Define an empty array to hold the items
        $items = [];

        // Generate 500 items
        for ($i = 0; $i < 500; $i++) {
            // Create a new item with fake data
            $items[] = [
                'item_name' => $faker->word,
                'company' => $faker->company,
                'group' => $faker->word,
                'mrp' => $faker->randomFloat(2, 1, 100),
                'sale_rate' => $faker->randomFloat(2, 1, 100),
                'unit' => $faker->randomElement(['kg', 'lb', 'piece']),
            ];
        }

        // Insert items into the database in chunks of 100
        $chunks = array_chunk($items, 100);
        foreach ($chunks as $chunk) {
            Item::insert($chunk);
        }
    }
}
