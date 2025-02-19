<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountgroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $primaryGroups = DB::table('primarygroups')
        ->pluck('id', 'primary_group_name')
        ->toArray();

    // Account groups data
    $accountGroups = [
        ['firm_id'=>'DATA0001','account_group_name' => 'Guest Customer', 'primary_group_name' => 'Sundry Debtors'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Cash In Hand', 'primary_group_name' => 'Current Assets'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Bank Account (Current)', 'primary_group_name' => 'Bank Accounts'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Profit & Loss', 'primary_group_name' => 'Profit & Loss'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Sales', 'primary_group_name' => 'Sale'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Purchase', 'primary_group_name' => 'Purchase'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Advertisement & Publicity', 'primary_group_name' => 'Expenses (Indirect/Admn.)'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Bank Charges', 'primary_group_name' => 'Expenses (Indirect/Admn.)'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Bad Debts Written Off', 'primary_group_name' => 'Expenses (Indirect/Admn.)'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Books & Periodicals', 'primary_group_name' => 'Expenses (Indirect/Admn.)'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Capital Equipments', 'primary_group_name' => 'Fixed Assets'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Central Sales Tax', 'primary_group_name' => 'Duties & Taxes'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Central Sales Tax', 'primary_group_name' => 'Duties & Taxes'],
        ['firm_id'=>'DATA0001','account_group_name' => 'Central Sales Tax', 'primary_group_name' => 'Duties & Taxes'],


        // More entries here...
    ];

    foreach ($accountGroups as $accountGroup) {
        // Check if the primary group exists
        if (isset($primaryGroups[$accountGroup['primary_group_name']])) {
            DB::table('accountgroups')->insert([
                'firm_id'=>'DATA0001','account_group_name' => $accountGroup['account_group_name'],
                'primary_group_id' => $primaryGroups[$accountGroup['primary_group_name']]
            ]);
        } else {
            // If the primary group doesn't exist, log an error
            \Log::error('Primary group not found for: ' . $accountGroup['primary_group_name']);
        }
    }
}










}
