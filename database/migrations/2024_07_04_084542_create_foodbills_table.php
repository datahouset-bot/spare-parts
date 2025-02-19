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
        Schema::create('foodbills', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->string('voucher_type');
            $table->unsignedBigInteger('voucher_no');
            $table->string('food_bill_no');
            $table->date('voucher_date');
            $table->unsignedBigInteger('service_id');
            $table->string('kot_no');
            $table->unsignedBigInteger('posting_acc_id')->nullable();
            $table->integer('net_food_bill_amount');
            $table->string('payment_remark')->nullable();
            $table->string('food_bill_remark')->nullable();
            $table->unsignedBigInteger('item_id');
            $table->string('item_name');
            $table->decimal('qty');
            $table->decimal('rate');
            $table->decimal('item_base_amount');
            $table->decimal('disc_percent')->nullable()->default('0');
            $table->decimal('disc_item_amount');
            $table->unsignedBigInteger('gst_id');
            $table->decimal('gst_item_percent');
            $table->decimal('gst_item_amount');
            $table->decimal('net_item_amount');
            $table->decimal('total_item');
            $table->decimal('total_qty');
            $table->decimal('total_base_amount');
            $table->decimal('cash_discount')->nullable()->default('0');
            $table->decimal('total_taxable_amount');
            $table->decimal('total_gst_amount');
            $table->decimal('total_amt_after_gst');
            $table->decimal('total_sgst');
            $table->decimal('total_cgst');
            $table->decimal('total_igst');
            $table->decimal('roundoff_amt');
            $table->decimal('total_bill_value');
            $table->string('status')->default('0');

                  



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foodbills');
    }
};
