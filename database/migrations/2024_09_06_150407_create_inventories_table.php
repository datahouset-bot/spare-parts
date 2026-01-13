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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->date('entry_date');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('user_name');
            $table->string('voucher_type');
            $table->unsignedBigInteger('voucher_no');
            $table->string('voucher_bill_no');
            $table->date('voucher_date');
            $table->unsignedBigInteger('godown_id');
            $table->foreign('godown_id')->references('id')->on('godowns');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->integer('net_voucher_amount');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->string('item_name');
            $table->decimal('qty');
            $table->decimal('rate');
            $table->decimal('item_basic_amount');
            $table->decimal('disc_percent')->nullable()->default('0');
            $table->decimal('disc_item_amount')->nullable()->default('0');
            $table->unsignedBigInteger('gst_id');
            $table->foreign('gst_id')->references('id')->on('gstmasters');
            $table->decimal('gst_item_percent');
            $table->decimal('gst_item_amount');
            $table->decimal('item_net_amount');
            $table->float('simpal_qty', 8, 2);
            $table->float('stock_in', 8, 2)->nullable();
            $table->float('stock_out', 8, 2)->nullable();

            $table->string('status')->default('0');
            $table->string('invent_af1')->nullable();
            $table->string('invent_af2')->nullable();
            $table->string('invent_af3')->nullable();  
            $table->string('invent_af4')->nullable();
            $table->string('invent_af5')->nullable();   
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
