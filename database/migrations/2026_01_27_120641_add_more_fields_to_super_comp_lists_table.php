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
        Schema::table('super_comp_lists', function (Blueprint $table) {
              $table->string('comp_af1')->nullable()->after('billing_amt');
            $table->string('comp_af2')->nullable()->after('comp_af1');
            $table->string('comp_af3')->nullable()->after('comp_af2');
            $table->string('comp_af4')->nullable()->after('comp_af3');
            $table->string('comp_af5')->nullable()->after('comp_af4');
            $table->string('comp_af6')->nullable()->after('comp_af5');
            $table->string('comp_af7')->nullable()->after('comp_af6'); 
            $table->string('comp_af8')->nullable()->after('comp_af7');                                   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('super_comp_lists', function (Blueprint $table) {
            //
        });
    }
};
