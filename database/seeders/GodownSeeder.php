<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GodownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Primary unit name, conversion factor, alternate unit name
            ['firm_id'=>'DATA0001','godown_name' => 'Main Store', 'godown_address' => 'Main Store', 'godown_af1' => '0','godown_af2'=>'0'],
            ['firm_id'=>'DATA0001','godown_name' => 'Kitchen', 'godown_address' => 'Main Store', 'godown_af1' => '0','godown_af2'=>'0'],
            ['firm_id'=>'DATA0001','godown_name' => 'Consume', 'godown_address' => 'Main Store', 'godown_af1' => '0','godown_af2'=>'0'],
         ];

        DB::table('godowns')->insert($data);
    }
}
