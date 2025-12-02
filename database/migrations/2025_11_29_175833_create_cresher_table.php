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
        Schema::create('creshers', function (Blueprint $table) {
            $table->id();

            // ===== BASIC INFO =====
            $table->string('slip_no')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            // ===== PARTY / VEHICLE =====
            $table->unsignedBigInteger('vehicle_id');
             $table->foreign('vehicle_id')->references('id')->on('vehicledetail');
            $table->string('vehicle_no')->nullable();
            $table->string('party_name')->nullable();
            $table->string('Vehicle_measure')->nullable();
            $table->string('Material')->nullable();

            // ===== MATERIAL DETAILS =====
            $table->decimal('Royalty', 10, 2)->nullable();
            $table->decimal('Quantity', 10, 2)->nullable();

            // ===== CONTACT =====
            $table->text('address')->nullable();
            $table->string('phone')->nullable();

            // ===== REMARK =====
            $table->text('remark')->nullable();

            // ===== IMAGE =====
            $table->string('pic')->nullable();

            // ==========total====
                $table->string('Total')->nullable();
                $table->string('Rate')->nullable();
            // ===== SYSTEM =====
            $table->timestamps();
            // =====additional field
    

            $table->string('af3')->nullable();
            $table->string('af4')->nullable();
            $table->string('af5')->nullable();
            $table->string('af6')->nullable();
            $table->string('af7')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cresher');
    }
};
