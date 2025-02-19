<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponyInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('componyinfos')->insert([
            [
                'firm_id' => 'DATA0001',
                'cominfo_firm_name' => 'Data House Company',
                'cominfo_address1' => '123 Tech Lane',
                'cominfo_address2' => 'Suite 400',
                'cominfo_city' => 'Tech City',
                'cominfo_pincode' => '123456',
                'cominfo_state' => 'Tech State',
                'cominfo_phone' => '1234567890',
                'cominfo_mobile' => '9876543210',
                'cominfo_email' => 'info@datahouse.com',
                'cominfo_gst_no' => 'GSTIN123456789',
                'cominfo_pencard' => 'ABCDE1234F',
                'cominfo_field1' => 'Extra Field 1',
                'cominfo_field2' => 'Extra Field 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
