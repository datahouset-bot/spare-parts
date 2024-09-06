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
        Schema::table('foodbills', function (Blueprint $table) {
            $table->string('customer_name')->after('status')->nullable();
            $table->string('address')->after('customer_name')->nullable();
            $table->string('mobile')->after('address')->nullable();
            $table->string('remark')->after('mobile')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('foodbills', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'address', 'mobile', 'remark']);
        });
    }
    
};
