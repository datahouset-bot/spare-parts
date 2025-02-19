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
        Schema::create('roombookings', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->string('booking_no');
            $table->string('voucher_no');
            $table->date('booking_date');
            $table->time('booking_time')->nullable();
            $table->date('checkin_date');
            $table->time('checkin_time')->nullable();
            $table->date('checkout_date');
            $table->time('checkout_time')->nullable();
            $table->integer('no_of_guest')->nullable();
            $table->integer('commited_days')->nullable();
            $table->unsignedBigInteger('business_source_id');
            $table->foreign('business_source_id')->references('id')->on('businesssources');
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->string('room_no')->nullable();
            $table->string('guest_name');
            $table->text('guest_address')->nullable();
            $table->text('guest_address2')->nullable();
            $table->string('guest_city')->nullable();
            $table->string('guest_state')->nullable();
            $table->string('guest_contery')->nullable();
            $table->string('guest_pincode')->nullable();
            $table->string('guest_nationality')->nullable();
            $table->string('guest_mobile');
            $table->string('guest_phone')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_idproof')->nullable();
            $table->string('guest_idproof_no')->nullable();
            $table->string('guest_id_pic')->nullable();
            $table->string('guest_pic')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('firm_address')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('room_tariff_perday')->nullable();
            $table->string('posting_acc_id')->nullable();
            $table->decimal('booking_amount', 10, 2)->nullable()->default('0');
            $table->string('refrance_no')->nullable();
            $table->string('voucher_payment_remark')->nullable();
            $table->string('agent')->nullable();
            $table->string('checkin_voucher_no')->default(0);
      
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roombookings');
    }
};
