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
            $table->unsignedBigInteger('userid')->nullable()->after('bill_type');
            $table->string('username')->nullable()->after('userid');
            $table->string('checkoutaf1')->nullable()->after('username');
            $table->string('checkoutaf2')->nullable()->after('checkoutaf1');
            $table->string('checkoutaf3')->nullable()->after('checkoutaf2');
            $table->string('checkoutaf4')->nullable()->after('checkoutaf3');
            $table->string('checkoutaf5')->nullable()->after('checkoutaf4');
        });
    }
    public function down()
{
    Schema::table('roomcheckouts', function (Blueprint $table) {
        $table->dropColumn(['userid', 'username', 'checkoutaf1', 'checkoutaf2', 'checkoutaf3', 'checkoutaf4', 'checkoutaf5']);
    });
}

    
};
