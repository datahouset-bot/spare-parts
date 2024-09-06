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
        Schema::create('amcs', function (Blueprint $table) {
            $table->id();
            $table->date('amc_start_date');
            $table->date('amc_end_date');
            $table->integer('amc_amount');
            $table->string('remark1')->nullable();
            $table->string('remark2')->nullable();
            $table->string('executive')->nullable();
            $table->unsignedBigInteger('cust_name_id');
            $table->foreign('cust_name_id')->references('id')->on('accounts');
            $table->unsignedBigInteger('amc_product_id');
            $table->foreign('amc_product_id')->references('id')->on('items');
            $table->timestamps();

            //  added column $table->string('payment_status')->after('executive');

            // added column $table->string('amc_status');

            // added column $table->integer('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amcs');
    }
};
