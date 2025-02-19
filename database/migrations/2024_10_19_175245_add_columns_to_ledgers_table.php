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
        Schema::table('ledgers', function (Blueprint $table) {
            $table->unsignedBigInteger('userid')->nullable()->after('tran_voucher_no');
            $table->string('username')->nullable()->after('userid');
            $table->string('la1')->nullable()->after('username');
            $table->string('la2')->nullable()->after('la1');
            $table->string('la3')->nullable()->after('la2');
        });
    }
    
    public function down()
    {
        Schema::table('ledgers', function (Blueprint $table) {
            $table->dropColumn(['userid', 'username', 'la1', 'la2', 'la3']);
        });
    }
    
};
