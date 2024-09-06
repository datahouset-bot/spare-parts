<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use Faker\Factory as Faker;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Initialize Faker library
        $faker = Faker::create();

        // Define an empty array to hold the accounts
        $accounts = [];

        // Generate 500 accounts
        for ($i = 0; $i < 500; $i++) {
            // Create a new account with fake data
            $accounts[] = [
                'account_name' => $faker->company,
                'account_group' => $faker->word,
                'op_balnce' => $faker->randomFloat(2, 0, 10000),
                'balnce_type' => $faker->randomElement(['credit', 'debit']),
                'city' => $faker->city,
                'state' => $faker->state,
                'phone' => $faker->phoneNumber,
                'mobile' => $faker->phoneNumber,
                'email' => $faker->email,
                'person_name' => $faker->name,
                'gst_no' => $faker->ean8,
            ];
        }

        // Insert accounts into the database in chunks of 100
        $chunks = array_chunk($accounts, 100);
        foreach ($chunks as $chunk) {
            Account::insert($chunk);
        }
    }
}
