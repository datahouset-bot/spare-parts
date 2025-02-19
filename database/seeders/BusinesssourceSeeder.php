<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinesssourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['firm_id'=>'DATA0001','business_source_name' => 'OYO', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Make My Trip', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Goibibo', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Direct', 'buiness_source_remark' => 'Direct Booking'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Booking.com', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Expedia', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Agoda', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Cleartrip', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Travelocity', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id'=>'DATA0001','business_source_name' => 'Hotels.com', 'buiness_source_remark' => 'Online Travel Agency'],
        ];

        DB::table('businesssources')->insert($data);
        //
    }
}
