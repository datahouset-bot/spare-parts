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
        Schema::create('quotations', function (Blueprint $table) {
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
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->decimal('total_qty');
            $table->decimal('total_item_basic_amount');
            $table->decimal('total_disc_item_amount')->nullable()->default('0');
            $table->decimal('total_gst_amount');
            $table->decimal('total_roundoff');
            $table->decimal('total_net_amount');
            $table->string('quot_af1')->nullable();
            $table->string('quot_af2')->nullable();
            $table->string('quot_af3')->nullable();
            $table->string('quot_af4')->nullable();
            $table->string('quot_af5')->nullable();
            $table->string('quot_af6')->nullable();
            $table->string('quot_af7')->nullable();
            $table->string('quot_af8')->nullable();
            $table->string('quot_af9')->nullable();
            $table->string('quot_af10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
