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
        Schema::table('roombookings', function (Blueprint $table) {
            $table->unsignedBigInteger('userid')->nullable()->after('checkin_voucher_no');
            $table->string('username')->nullable()->after('userid');
            $table->string('bookingaf1')->nullable()->after('username');
            $table->string('bookingaf2')->nullable()->after('bookingaf1');
            $table->string('bookingaf3')->nullable()->after('bookingaf2');
            $table->string('bookingaf4')->nullable()->after('bookingaf3');
            $table->string('bookingaf5')->nullable()->after('bookingaf4');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('roombookings', function (Blueprint $table) {
            $table->dropColumn(['userid', 'username', 'bookingaf1', 'bookingaf2', 'bookingaf3', 'bookingaf4', 'bookingaf5']);
        });
    }
    
};
