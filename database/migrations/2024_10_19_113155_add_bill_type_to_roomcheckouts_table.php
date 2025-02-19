<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('roomcheckouts', function (Blueprint $table) {
            $table->string('bill_type')->nullable()->after('checkin_voucher_no');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('roomcheckouts', function (Blueprint $table) {
            $table->dropColumn('bill_type');
        });
    }
    
};
