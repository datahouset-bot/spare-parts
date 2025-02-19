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
        Schema::table('roomcheckins', function (Blueprint $table) {
            $table->unsignedBigInteger('userid')->nullable()->after('booking_voucher_no');
            $table->string('username')->nullable()->after('userid');
            $table->string('checkinaf1')->nullable()->after('username');
            $table->string('checkinaf2')->nullable()->after('checkinaf1');
            $table->string('checkinaf3')->nullable()->after('checkinaf2');
            $table->string('checkinaf4')->nullable()->after('checkinaf3');
            $table->string('checkinaf5')->nullable()->after('checkinaf4');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('roomcheckins', function (Blueprint $table) {
            $table->dropColumn(['userid', 'username', 'checkinaf1', 'checkinaf2', 'checkinaf3', 'checkinaf4', 'checkinaf5']);
        });
    }
    
};
