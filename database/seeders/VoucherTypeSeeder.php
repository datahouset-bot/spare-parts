<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [   'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Check_In',
                'numbring_start_from' => 50,
                'voucher_prefix' => 'SR/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Check In',
                'voucher_remark' => 'Check In',
            ],
            [
                'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Check_out',
                'numbring_start_from' => 100,
                'voucher_prefix' => 'GSR/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Tax Invoice',
                'voucher_remark' => 'Check Out',
            ],
            [ 'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Receipts',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'REC/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Receipts',
                'voucher_remark' => 'Payment Receipts',
            ],
            [ 'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Payments',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'PAY/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Payments',
                'voucher_remark' => 'Payments',
            ],
            [ 'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Room_booking',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'RM/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Room Booking',
                'voucher_remark' => 'Room Booking',
            ],
            ['firm_id'=>'DATA0001',
                'voucher_type_name' => 'Kot',
                'numbring_start_from' => 100,
                'voucher_prefix' => 'KOT/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'KOT',
                'voucher_remark' => 'KOT',
            ],
            [
                'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Foodbill',
                'numbring_start_from' => 100,
                'voucher_prefix' => 'SHRI/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Food Bill',
                'voucher_remark' => 'Food Bill',
            ],
            [
                'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Advance_Receipt',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'AR',
                'voucher_suffix' => '',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Advace Receipt',
                'voucher_remark' => 'Advace Receipt',
            ],
            [
                'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Purchase',
                'numbring_start_from' => 0,
                'voucher_prefix' => '',
                'voucher_suffix' => '',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => '',
                'voucher_remark' => '',
            ],
            [
                'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Restaurant_food_bill',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'Res/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => '1',
                'voucher_remark' => 'Restaurant Food Bill',
            ],
            [
                'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Sale',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'S/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Sale',
                'voucher_remark' => 'Sale',
            ],
            [ 'firm_id'=>'DATA0001',
                'voucher_type_name' => 'Stock_Transfer',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'ST/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Stock_Transfer',
                'voucher_remark' => 'Stock_Transfer',
            ],
            [ 'firm_id'=>'DATA0001',
                'voucher_type_name' => 'My_Check_out',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'MY/',
                'voucher_suffix' => '/24-25',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'My Check Out',
                'voucher_remark' => 'My Check Out',
            ],
        ];

        DB::table('voucher_types')->insert($data);
    
        //
    }
}
