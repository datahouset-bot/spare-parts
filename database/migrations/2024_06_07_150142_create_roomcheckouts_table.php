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
        Schema::create('roomcheckouts', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no');
            $table->string('check_out_no');
            $table->date('checkin_date');
            $table->time('checkin_time');
            $table->date('checkout_date');
            $table->time('check_out_time');
            $table->string('calculation_type');
            $table->integer('no_of_days')->nullable();
            $table->decimal('per_day_tariff', 8, 2)->nullable();
            $table->decimal('total_room_rent', 10, 2)->nullable();
            $table->decimal('gst_id', 10, 2)->nullable();
            $table->decimal('gst_total', 10, 2)->nullable();
            $table->decimal('final_room_rent', 10, 2)->nullable();
            $table->decimal('total_food_amt', 10, 2)->nullable();
            $table->decimal('other_charge', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total_billamount', 10, 2)->nullable();            
            $table->decimal('total_advance', 10, 2)->nullable();
            $table->decimal('balance_to_pay', 10, 2)->nullable();
            $table->decimal('voucher_posting_amt', 10, 2)->nullable();
            $table->unsignedBigInteger('posting_acc_id')->nullable();
            $table->foreign('posting_acc_id')->references('id')->on('accounts');
            $table->decimal('amt_post_credit_amt', 10, 2)->nullable();
            $table->unsignedBigInteger('amt_post_credit_id')->nullable();
            $table->foreign('amt_post_credit_id')->references('id')->on('accounts');    
            $table->string('checkout_remark')->nullable();
             $table->string('voucher_payment_remark')->nullable();
            $table->string('voucher_payment_ref')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('gst_code')->nullable();
             $table->string('guest_name');
            $table->string('guest_mobile');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->text('room_no');
            $table->text('room_id');
            $table->string('checkin_voucher_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roomcheckouts');
    }
};
