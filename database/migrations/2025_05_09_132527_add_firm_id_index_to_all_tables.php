<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = [
            'accountgroups', 'accounts', 'amcs', 'banquets', 'businesssettings', 'businesssources',
            'companies', 'compinfofooters', 'componyinfos', 'domains', 'failed_jobs', 'followups',
            'foodbills', 'godowns', 'gstmasters', 'inventories', 'itemgroups', 'items', 'kots',
            'leads', 'ledgers', 'maintenancemodes', 'migrations', 'model_has_permissions',
            'model_has_roles', 'optionlists', 'othercharges', 'packages', 'password_reset_tokens',
            'password_resets', 'permissions', 'personal_access_tokens', 'pics', 'primarygroups',
            'role_has_permissions', 'roles', 'roombookings', 'roomcheckins', 'roomcheckouts', 'rooms',
            'roomtypes', 'sales', 'softwarecompanies', 'stocktransfers', 'super_comp_lists', 'tables',
            'tempentries', 'tenants', 'tests', 'todos', 'units', 'users', 'voucher_types', 'vouchers',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexes = $sm->listTableIndexes($tableName);

                // Add index for firm_id if it exists and not already indexed
                if (Schema::hasColumn($tableName, 'firm_id')) {
                    $firmIndex = "{$tableName}_firm_id_index";
                    if (!array_key_exists($firmIndex, $indexes)) {
                        $table->index('firm_id', $firmIndex);
                    }
                }

                // Add index for mobile only in accounts table
                if ($tableName === 'accounts' && Schema::hasColumn('accounts', 'mobile')) {
                    $mobileIndex = "accounts_mobile_index";
                    if (!array_key_exists($mobileIndex, $indexes)) {
                        $table->index('mobile', $mobileIndex);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'accountgroups', 'accounts', 'amcs', 'banquets', 'businesssettings', 'businesssources',
            'companies', 'compinfofooters', 'componyinfos', 'domains', 'failed_jobs', 'followups',
            'foodbills', 'godowns', 'gstmasters', 'inventories', 'itemgroups', 'items', 'kots',
            'leads', 'ledgers', 'maintenancemodes', 'migrations', 'model_has_permissions',
            'model_has_roles', 'optionlists', 'othercharges', 'packages', 'password_reset_tokens',
            'password_resets', 'permissions', 'personal_access_tokens', 'pics', 'primarygroups',
            'role_has_permissions', 'roles', 'roombookings', 'roomcheckins', 'roomcheckouts', 'rooms',
            'roomtypes', 'sales', 'softwarecompanies', 'stocktransfers', 'super_comp_lists', 'tables',
            'tempentries', 'tenants', 'tests', 'todos', 'units', 'users', 'voucher_types', 'vouchers',
        ];

        foreach ($tables as $tableName) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes($tableName);

            // Drop firm_id index if exists
            $firmIndex = "{$tableName}_firm_id_index";
            if (Schema::hasColumn($tableName, 'firm_id') && array_key_exists($firmIndex, $indexes)) {
                Schema::table($tableName, function (Blueprint $table) use ($firmIndex) {
                    $table->dropIndex($firmIndex);
                });
            }

            // Drop mobile index only in accounts table
            if ($tableName === 'accounts') {
                $mobileIndex = "accounts_mobile_index";
                if (Schema::hasColumn('accounts', 'mobile') && array_key_exists($mobileIndex, $indexes)) {
                    Schema::table('accounts', function (Blueprint $table) use ($mobileIndex) {
                        $table->dropIndex($mobileIndex);
                    });
                }
            }
        }
    }
};
