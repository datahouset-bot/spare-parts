<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->string('table_group')->nullable()->after('table_name');
            $table->string('tab_af1')->nullable()->after('table_group');
            $table->string('tab_af2')->nullable()->after('tab_af1');
            $table->string('tab_af3')->nullable()->after('tab_af2');
        });
    }
    
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn(['table_group', 'tab_af1', 'tab_af2', 'tab_af3']);
        });
    }
    
};
