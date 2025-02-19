<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Primary unit name, conversion factor, alternate unit name
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Kilogram', 'conversion' => 1, 'alternate_unit_name' => 'Gram'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Gram', 'conversion' => 1000, 'alternate_unit_name' => 'Milligram'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Litre', 'conversion' => 1, 'alternate_unit_name' => 'Millilitre'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Millilitre', 'conversion' => 1000, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Piece', 'conversion' => 1, 'alternate_unit_name' => 'Unit'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Packet', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Dozen', 'conversion' => 12, 'alternate_unit_name' => 'Pieces'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Box', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Plate', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Bottle', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Cup', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Spoon', 'conversion' => 1, 'alternate_unit_name' => 'Teaspoon'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Teaspoon', 'conversion' => 3, 'alternate_unit_name' => 'Tablespoon'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Tablespoon', 'conversion' => 1, 'alternate_unit_name' => 'Teaspoon'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Carton', 'conversion' => 1, 'alternate_unit_name' => 'Packet'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Tray', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Bundle', 'conversion' => 1, 'alternate_unit_name' => 'Packet'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Pint', 'conversion' => 0.473, 'alternate_unit_name' => 'Litre'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Quart', 'conversion' => 0.946, 'alternate_unit_name' => 'Litre'],
            ['firm_id'=>'DATA0001','primary_unit_name' => 'Gallon', 'conversion' => 3.785, 'alternate_unit_name' => 'Litre'],
        ];

        DB::table('units')->insert($data);
    }
}
