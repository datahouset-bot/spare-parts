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
        Schema::create('kots', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->date('entry_date');
            $table->unsignedBigInteger('voucher_no');
            $table->date('voucher_date');
            $table->string('voucher_type');
            $table->string('bill_no');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->string('item_name');
            $table->decimal('qty');
            $table->decimal('rate');
            $table->decimal('amount');
            $table->decimal('total_qty');
            $table->decimal('total_amount');
            $table->string('kot_remark')->nullable();
            $table->unsignedBigInteger('service_id'); 
            // $table->foreign('service_id')->references('voucher_no')->on('roomcheckins');
            $table->string('ready_to_serve')->default('0');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kots');
    }
};
