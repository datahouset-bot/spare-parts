<?php

namespace  Database\Seeders;

use  App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions

        $permissions = [
            'view role',
            'create role',
            'update role',
            'delete role',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'view user',
            'create user',
            'update user',
            'delete user',
            'view product',
            'create product',
            'update product',
            'delete product',
            'roombooking',
            'roomcheckin',
            'roomcheckout',
            'payment',
            'receipt',
            'advance_reciept',
            'foodbills',
            'kot',
            'ledger',
            'Restaurant',
            'purchase',
            'Stock_Transfer',
            'sale',
            'Report',
            'Room_Dashboard',
            'Master',
            'Entry',
            'ReportList',
            'Membership',
            'Activity',
            'Setting',
            'sql_query',
            'Booking Calendar',
            'Unconfirmed Bookings',
            'Kitchen Dash Board',
            'Outstanding Receivable',
            'Outstanding Payable',
            'Police Station Report',
            'Item Wise Sale Report',
            'Day End Report',
            'Booking Register',
            'Check-in Register',
            'Room Food Bills',
            'Advance Receipt Reg',
            'Checkout Register',
            'Restaurant Food Bills',
            'Kot Register',
            'Stock Status',
            'Store Wise Stock',
            'Stock In Register',
            'Stock Out Register',
            'Stock Transfer Register',
            'Item List',
            'Room List',
            'Account List',
            'Add',
            'Print',
            'View',
            'Delete',
            'Edit',
            'Save',
            'Handover',
            'Mycheckout',
            'GST Report',
            'Checkout_Reg',
            'Month Wise Sale',
            'B2B Sale',
            'B2C Sale',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
        // Permission::create(['name' => 'view role']);
        // Permission::create(['name' => 'create role']);
        // Permission::create(['name' => 'update role']);
        // Permission::create(['name' => 'delete role']);




        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);
        $userRole = Role::create(['name' => 'user']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        $adminRole->givePermissionTo(['create permission', 'view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);
        $adminRole->givePermissionTo(['create product', 'view product', 'update product']);


        // Let's Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
                    'email' => 'superadmin@gmail.com',
                ], [
                    'name' => 'Super Admin',
                    'firm_id'=>'DATA0001',
                    'email' => 'superadmin@gmail.com',
                    'email_verified_at'=>now(),
                    'password' => Hash::make ('12345678'),
                ]);

        $superAdminUser->assignRole($superAdminRole);

        $superAdminUser2 = User::firstOrCreate([
            'email' => 'datahouset@gmail.com',
        ], [
            'name' => 'Data House',
            'firm_id'=>'DATA0001',
            'email' => 'datahouset@gmail.com',
            'email_verified_at'=>now(),
            'password' => Hash::make ('India@77'),
        ]);

$superAdminUser2->assignRole($superAdminRole);


        $adminUser = User::firstOrCreate([
                            'email' => 'admin@gmail.com'
                        ], [
                            'name' => 'Admin',
                            'firm_id'=>'DATA0001',
                            'email' => 'admin@gmail.com',
                            'email_verified_at'=>now(),
                            'password' => Hash::make ('12345678'),
                        ]);

        $adminUser->assignRole($adminRole);


        $staffUser = User::firstOrCreate([
                            'email' => 'staff@gmail.com',
                        ], [
                            'name' => 'Staff',
                            'firm_id'=>'DATA0001',
                            'email' => 'staff@gmail.com',
                            'email_verified_at'=>now(),
                            'password' => Hash::make('12345678'),
                        ]);

        $staffUser->assignRole($staffRole);
    }
}