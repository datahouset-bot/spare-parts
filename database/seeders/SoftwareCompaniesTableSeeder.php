<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SoftwareCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('softwarecompanies')->insert([
            ['firm_id'=>'DATA0001',
                'activation_date' => now(),
                'expiry_date' => now()->addYear(),
                'customer_firm_name' => 'Data House ERP',
                'customer_mobile' => '0',
                'customer_phone' => '0',
                'software_firm_name' => 'Data House ERP',
                'software_address1' => 'Shop No 8 3rrd Floor Good Luck ',
                'software_address2' => 'Apartment Shri Nath Ki taliya ',
                'software_city' => 'Jabalpur',
                'software_pincode' => '482001',
                'software_state' => 'Madhya Pradesh ',
                'software_phone' => '7999663696',
                'software_mobile' => '8871702803',
                'software_email' => 'datahousejbp@gmail.com',
                'software_website' => 'https://datahouse',
                'software_facebook' => 'https://facebook.com/datahouse',
                'software_youtube' => 'https://youtube.com/datahouse',
                'software_twitter' => 'https://twitter.com/datahouse',
                'software_logo1' => 'https://datahouse.com/logo1.png',
                'software_logo2' => 'https://datahouse.com/logo2.png',
                'software_logo3' => 'https://datahouse.com/logo3.png',
                'software_logo4' => 'https://datahouse.com/logo4.png',
                'software_af1' => 'af',
                'software_af2' => 'af',
                'software_af3' => 'af',
                'software_af4' => 'af',
                'software_af5' => 'af',
                'software_af6' => 'af',
                'software_af7' => 'af',
                'software_af8' => 'af',
                'software_af9' => 'af',
                'software_af10' => 'af',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}
