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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->string('voucher_no');
            $table->string('reciept_no');
            $table->date('entry_date'); // Corrected 'entery_date' to 'entry_date'
            $table->string('transaction_type', 100); // Corrected 'transection_type' to 'transaction_type'
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('account_name', 150);
            $table->unsignedBigInteger('account_group_id');
            $table->foreign('account_group_id')->references('id')->on('accountgroups');
            $table->unsignedBigInteger('payment_mode_id');
            $table->foreign('payment_mode_id')->references('id')->on('accounts');
            $table->string('payment_mode_name', 150);  
            $table->string('account_group_name', 150);
            $table->unsignedBigInteger('primary_group_id');
            $table->foreign('primary_group_id')->references('id')->on('primarygroups');
            $table->string('primary_group_name', 150);
            $table->float('debit', 50)->nullable();
            $table->float('credit', 50)->nullable();
            $table->integer('amount');
            $table->string('remark')->nullable();
            $table->float('simpal_amount', 8, 2);
            $table->unsignedBigInteger('tran_voucher_no')->default('0')->nullable(); //voucher _no  for refrance 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
