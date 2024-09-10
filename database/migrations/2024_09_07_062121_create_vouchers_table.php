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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
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
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
