<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['firm_id'=>'DATA0001','table_name' => '1'],
            ['firm_id'=>'DATA0001','table_name' => '2'],
            ['firm_id'=>'DATA0001','table_name' => '3'],
            ['firm_id'=>'DATA0001','table_name' => '4'],
            ['firm_id'=>'DATA0001','table_name' => '5'],
            ['firm_id'=>'DATA0001','table_name' => '6'],
            ['firm_id'=>'DATA0001','table_name' => '7'],
            ['firm_id'=>'DATA0001','table_name' => '8'],
            ['firm_id'=>'DATA0001','table_name' => '9'],
            ['firm_id'=>'DATA0001','table_name' => '10'],
        ];

        DB::table('tables')->insert($data);
    }
}
