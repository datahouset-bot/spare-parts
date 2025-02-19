<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrimarygroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['firm_id'=>'DATA0001','primary_group_name' => 'Sundry Debtors'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Sundry Creditors'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Cash-in-hand'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Stock-in-hand'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Profit & Loss'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Sale'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Purchase'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Expenses (Indirect/Admn.)'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Fixed Assets'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Duties & Taxes'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Securities & Deposits (Asset)'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Provisions/Expenses Payable'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Expenses (Direct/Mfg.)'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Income (Indirect)'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'SELF STOCK'],
            ['firm_id'=>'DATA0001','primary_group_name' => 'Current Assets'],
        ];

        DB::table('primarygroups')->insert($data);
    }

}
