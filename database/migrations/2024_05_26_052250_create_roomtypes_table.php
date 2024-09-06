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
        Schema::create('roomtypes', function (Blueprint $table) {
            $table->id();
            $table->string('roomtype_name',50);
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('restrict')->onUpdate('cascade');

            $table->unsignedBigInteger('gst_id');
            $table->foreign('gst_id')->references('id')->on('gstmasters')->onDelete('restrict')->onUpdate('cascade');
            $table->string('room_tariff',50)->nullable()->default('0');
            $table->string('room_dis',50)->nullable()->default('0');
            $table->string('room_type_af1',50)->nullable();
            $table->string('room_type_af2',50)->nullable();
            $table->string('room_type_af3',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roomtypes');
    }
};
