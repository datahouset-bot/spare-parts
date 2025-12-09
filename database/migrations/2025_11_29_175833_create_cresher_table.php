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
            $table->unsignedBigInteger('slip_no')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();

            // ===== ACCOUNT =====
            $table->unsignedBigInteger('acc_id');
            $table->foreign('acc_id')->references('id')->on('accounts')->onDelete('cascade');

            // ===== VEHICLE DETAILS =====
          $table->unsignedBigInteger('vehicle_id');
$table->foreign('vehicle_id')
      ->references('id')
      ->on('vehicledetails')
      ->onDelete('cascade');

            $table->string('vehicle_no')->nullable();
            $table->string('party_name')->nullable();
            $table->string('vehicle_measure')->nullable();

            // ===== MATERIAL DETAILS =====
            $table->string('Material')->nullable();
            $table->string('Materialremark')->nullable();

            $table->decimal('Quantity', 10, 2)->nullable();
            $table->decimal('Rate', 10, 2)->nullable();
            $table->string('unit')->nullable();

            // ===== ROYALTY DETAILS =====
            $table->decimal('Royalty_Quantity', 10, 2)->nullable();
            $table->decimal('Royalty_Rate', 10, 2)->nullable();
            $table->decimal('Royalty', 10, 2)->nullable();

            // ===== FINANCIAL =====
            $table->decimal('Total', 12, 2)->nullable();

            // ===== CONTACT =====
            $table->text('address')->nullable();
            $table->string('phone')->nullable();

            // ===== REMARK =====
            $table->text('remark')->nullable();

            // ===== IMAGE =====
            $table->string('pic')->nullable();

            // ===== ADDITIONAL FIELDS =====
            $table->string('af3')->nullable();
            $table->string('af4')->nullable();
            $table->string('af5')->nullable();
            $table->string('af6')->nullable();
            $table->string('af7')->nullable();

            // ===== SYSTEM =====
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creshers');
    }
};
