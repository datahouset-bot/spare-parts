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
        Schema::create('cctv_visit', function (Blueprint $table) {
            $table->id();
            // Basic Visit Info
            $table->string('csr')->nullable();
            $table->string('date')->nullable();

            // Customer
            $table->unsignedBigInteger('customer_name')->nullable(); // account id

            // Address Details
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            // Product & Issue
            $table->unsignedBigInteger('product')->nullable(); // item id
            $table->string('problem')->nullable();

            // System & Call Status
            $table->string('system_status')->nullable();
            $table->string('call_status')->nullable();

            // Equipment
            $table->string('equipment_type')->nullable();

            // Device Info
            $table->string('make')->nullable();
            $table->string('serial_no')->nullable();

            // Call Details
            $table->string('reported')->nullable();
            $table->string('location')->nullable();

            // Service Time
            $table->date('serviceDate')->nullable();
            $table->time('servicetime')->nullable();

            // Service Description
            $table->string('rendered')->nullable();

            // additional field
            $table->string('af1')->nullable();
            $table->string('af2')->nullable();
            $table->string('af3')->nullable();
            $table->string('af4')->nullable();
            $table->string('af5')->nullable();
            $table->string('af6')->nullable();
            $table->string('af7')->nullable();
            $table->string('af8')->nullable();
            $table->string('af9')->nullable();
            $table->string('af10')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_visit');
    }
};
