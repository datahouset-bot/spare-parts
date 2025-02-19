<?php

namespace Database\Seeders;

use App\Models\accountgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Disable foreign key checks to avoid constraint issues
        Schema::disableForeignKeyConstraints();

        // Insert the account record into the database
        DB::table('accounts')->insert([
            'firm_id'=>'DATA0001',
            'account_name' => 'Sale',
            'account_group_id' => 17,
            'op_balnce' => 0,
            'balnce_type' => 'Dr',
            'address' => null,
            'city' => null,
            'state' => null,
            'phone' => null,
            'mobile' => null,
            'email' => null,
            'person_name' => null,
            'gst_no' => null,
            // 'pincode' => '0',
            // 'nationality' => '0',
            // 'address2' => '0',
            // 'pen_card' => '0',
            // 'account_idproof_name' => '0',
            // 'account_idproof_no' => '0',
            // 'account_id_pic' => '0',
            // 'account_pic1' => '0',
            // 'account_attachment1' => '0',
            // 'account_route' => '0',
            // 'account_salsman' => '0',
            // 'account_cr_days' => '0',
            // 'account_birthday' => '0',
            // 'account_anniversary' => '0',
            // 'account_code' => '0',
            // 'gst_code' => '0',
            // 'account_dl1' => '0',
            // 'account_dl2' => '0',
            // 'account_af1' => '0',
            // 'account_af2' => '0',
            'account_af3' => 'YES',
            // 'account_af4' => '0',
            // 'account_af5' => '0',
            // 'account_af6' => '0',
            // 'account_af7' => '0',
            // 'account_af8' => '0',
            // 'account_af9' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }
}
