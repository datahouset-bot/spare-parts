<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompinfofooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('compinfofooters')->insert([
            [
                'bank_name' => 'Bank A',
                'bank_ac_no' => '1234567890',
                'bank_ifsc' => 'IFSC001',
                'upiid' => 'upi123@bank',
                'pay_no' => '9876543210',
                'bank_branch' => 'Branch A',
                'voucher_prefix' => 'VP',
                'voucher_suffix' => 'VS',
                'voucher_note' => 'Note A',
                'country' => 'Country A',
                'currency' => 'Currency A',
                'terms' => 'Terms A',
                'ct1' => 'Contact 1',
                'ct2' => 'Contact 2',
                'ct3' => 'Contact 3',
                'ct4' => 'Contact 4',
                'ct5' => 'Contact 5',
                'ct6' => 'Contact 6',
                'ct7' => 'Contact 7',
                'ct8' => 'Contact 8',
                'ct9' => 'Contact 9',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more entries as needed
        ]);
    }
}
