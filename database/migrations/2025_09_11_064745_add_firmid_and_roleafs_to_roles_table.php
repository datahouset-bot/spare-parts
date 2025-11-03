<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // add firm_id before created_at
            $table->string('firm_id')->nullable()->after('created_at');
            
            // add role_af1, role_af2, role_af3 (all string, nullable)
            $table->string('role_af1')->nullable()->after('firm_id');
            $table->string('role_af2')->nullable()->after('role_af1');
            $table->string('role_af3')->nullable()->after('role_af2');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['firm_id', 'role_af1', 'role_af2', 'role_af3']);
        });
    }
};
