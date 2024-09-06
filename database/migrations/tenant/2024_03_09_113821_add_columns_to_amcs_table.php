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
        Schema::table('amcs', function (Blueprint $table) {
            
            $table->string('payment_status')->after('executive');

            // Add amc_status column
            $table->string('amc_status');

            // Add priority column
            $table->string('priority');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amcs', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('amc_status');
            $table->dropColumn('priority');
                        //
        });
    }
};
