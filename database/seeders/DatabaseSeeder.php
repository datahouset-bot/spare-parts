<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CompinfofooterSeeder::class,
            UserRolePermissionSeeder::class,
            ComponyInfosTableSeeder::class,
            PicsTableSeeder::class,
           
            SoftwareCompaniesTableSeeder::class,
            VoucherTypeSeeder::class,
            GstmasterSeeder::class,
            UnitSeeder::class,
            TableSeeder::class,
            BusinesssourceSeeder::class,
            GodownSeeder::class,
            PrimarygroupSeeder::class,
            AccountgroupSeeder::class
        ]);
    }
}
