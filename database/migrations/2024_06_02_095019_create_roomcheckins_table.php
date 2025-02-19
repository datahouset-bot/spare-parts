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
        Schema::create('roomcheckins', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->string('check_in_no');
            $table->string('voucher_no');
            $table->date('checkin_date');
            $table->time('checkin_time');
            $table->integer('commited_days')->nullable();
            $table->integer('no_of_guest')->nullable();
            $table->unsignedBigInteger('business_source_id');
            $table->foreign('business_source_id')->references('id')->on('businesssources');
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->string('room_no');
            $table->string('checkin_remark1')->nullable();
            $table->string('checkin_remark2')->nullable();

            $table->string('guest_name');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('guest_mobile');
            // $table->decimal('value_added_service', 10, 2)->nullable();
            $table->string('purpose_of_visit')->nullable();
            $table->string('comming_from')->nullable();
            $table->string('going_to')->nullable();
            $table->string('agent')->nullable();
            $table->decimal('room_tariff_perday', 10, 2)->nullable();
            $table->string('posting_acc_id')->nullable();
            $table->decimal('checkin_advance', 10, 2)->nullable();
            $table->string('voucher_payment_ref')->nullable();
            $table->string('voucher_payment_remark')->nullable();


            $table->bigInteger('checkout_voucher_no')->nullable()->default('0');
            $table->bigInteger('booking_voucher_no')->nullable()->default('0');



            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roomcheckins');
    }
};
