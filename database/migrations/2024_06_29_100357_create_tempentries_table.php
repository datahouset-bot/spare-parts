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
        Schema::create('tempentries', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('voucher_date')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('voucher_type')->nullable();
            $table->string('bill_no')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('sale_to_voucher_no')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->float('qty')->nullable();
            $table->float('rate')->nullable();
            $table->float('discount')->nullable();
            $table->unsignedBigInteger('item_gst_id')->nullable();
            $table->string('item_gst_name')->nullable();
            $table->float('amount')->nullable();
            $table->float('total_qty')->nullable();
            $table->float('total_discount')->nullable();
            $table->float('total_gst')->nullable();
            $table->float('total_roundoff')->nullable();
            $table->float('total_amount')->nullable();
            $table->string('voucher_remark')->nullable();
            $table->string('account_id')->nullable(); 

            $table->string('basic')->nullable(); 
            $table->string('dis_percent')->nullable();
            $table->string('dis_amt')->nullable();
            $table->string('item_net_value')->nullable();
            $table->string('temp_af1')->nullable();
            $table->string('temp_af2')->nullable();
            $table->string('temp_af3')->nullable();
            $table->string('temp_af4')->nullable();
            $table->string('temp_af5')->nullable(); 
            $table->string('temp_af6')->nullable(); 
            $table->string('temp_af7')->nullable(); 
            $table->string('temp_af8')->nullable(); 
            $table->string('temp_af9')->nullable(); 
            $table->string('temp_af10')->nullable(); 
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempentries');
    }
};
