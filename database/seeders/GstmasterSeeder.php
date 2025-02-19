<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GstmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'firm_id'=>'DATA0001',
                'taxname' => 'GST 5%',
                'sgst' => 2.5000,
                'cgst' => 2.5000,
                'igst' => 5.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            ['firm_id'=>'DATA0001',
                'taxname' => 'GST 12%',
                'sgst' => 6.0000,
                'cgst' => 6.0000,
                'igst' => 12.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            [
                'firm_id'=>'DATA0001',
                'taxname' => 'GST 18%',
                'sgst' => 9.0000,
                'cgst' => 9.0000,
                'igst' => 18.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            ['firm_id'=>'DATA0001',
                'taxname' => 'GST 28%',
                'sgst' => 14.0000,
                'cgst' => 14.0000,
                'igst' => 28.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            [
                'firm_id'=>'DATA0001',
                'taxname' => 'GST 0%',
                'sgst' => 0,
                'cgst' => 0,
                'igst' => 0,
                'vat' => 0,
                'tax1' => 0,
                'tax2' => 0,
                'tax3' => 0,
                'tax4' => 0,
                'tax5' => 0,
            ],
        ];

        DB::table('gstmasters')->insert($data);
    }

        //
    
}
