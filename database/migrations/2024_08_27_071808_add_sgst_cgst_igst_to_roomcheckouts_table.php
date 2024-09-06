<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('roomcheckouts', function (Blueprint $table) {
            $table->decimal('sgst', 8, 2)->after('gst_total')->nullable();
            $table->decimal('cgst', 8, 2)->after('sgst')->nullable();
            $table->decimal('igst', 8, 2)->after('cgst')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('roomcheckouts', function (Blueprint $table) {
            $table->dropColumn(['sgst', 'cgst', 'igst']);
        });
    }
    
};
