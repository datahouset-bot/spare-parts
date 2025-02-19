<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pics')->insert([
            [
                'firm_id'=>'DATA0001',
                'logo' => 'logo1.png',
                'qrcode' => 'qrcode1.png',
                'seal' => 'seal1.png',
                'signature' => 'signature1.png',
                'brand' => 'Brand A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ 'firm_id'=>'DATA0001',
                'logo' => 'logo2.png',
                'qrcode' => 'qrcode2.png',
                'seal' => 'seal2.png',
                'signature' => 'signature2.png',
                'brand' => 'Brand B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firm_id'=>'DATA0001',
                'logo' => 'logo3.png',
                'qrcode' => 'qrcode3.png',
                'seal' => 'seal3.png',
                'signature' => 'signature3.png',
                'brand' => 'Brand C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
