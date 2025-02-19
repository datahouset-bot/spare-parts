<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['id' => 1, 'name' => 'view role', 'guard_name' => 'web', 'created_at' => '2024-07-29 08:04:35', 'updated_at' => '2024-07-29 08:04:35'],
            ['id' => 2, 'name' => 'create role', 'guard_name' => 'web', 'created_at' => '2024-07-29 08:04:39', 'updated_at' => '2024-07-29 08:04:39'],
            // Add more entries here, following the same format
            ['id' => 77, 'name' => 'B2C Sale', 'guard_name' => 'web', 'created_at' => '2024-10-20 03:53:17', 'updated_at' => '2024-10-20 03:53:17'],
        ];

        DB::table('permissions')->insert($permissions);
    }
}

