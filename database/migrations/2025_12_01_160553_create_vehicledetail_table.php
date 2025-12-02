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
        Schema::create('vehicledetail', function (Blueprint $table) {
            $table->id()->autoIncrement();

            // vehicle Details
            $table->string('vehicle_name');
            $table->string('owner_name');
            $table->string('Vehicle_no');
            $table->string('vehicle_measure')->nullable();
            $table->string('Registration_date');

            // driver details
            $table->string('Driver_name');
            $table->string('Driver_contact');
            $table->string('Driver_address')->nullable();
            $table->string('model_year');
            

            // ====================additional details====================
            $table->string('Insaurance')->nullable();
            $table->string('Puc')->nullable();
            

            // =================additional fields==========================
            $table->string('af4')->nullable();
            $table->string('af5')->nullable();
            $table->string('af6')->nullable();
            $table->string('af7')->nullable();
            $table->string('af8')->nullable();
            $table->string('af9')->nullable();


            //=======system=================
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicledetail');
    }
};
