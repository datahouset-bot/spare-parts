<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amc;
use Faker\Factory as Faker;

class AmcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Initialize Faker library
        $faker = Faker::create();

        // Generate 500 seeders
        for ($i = 0; $i < 500; $i++) {
            // Create a new amc with fake data
            // artisan command php artisan db:seed --class=AmcSeeder 
            Amc::create([
                'amc_start_date' => $faker->date,
                'amc_end_date' => $faker->date,
                'amc_amount' => $faker->randomFloat(2, 0, 10000),
                'remark1' => $faker->sentence,
                'remark2' => $faker->sentence,
                'executive' => $faker->name,
                'cust_name_id' => $faker->randomNumber(1,400),
                'amc_product_id' => $faker->randomNumber(1,400),
                'payment_status' => $faker->randomElement(['Paid', 'Unpaid']),
                'amc_status' => $faker->randomElement(['Active', 'Inactive']),
                'priority' => $faker->randomElement(['Gold','silver','bronze']),
            ]);
        }
    }
}
