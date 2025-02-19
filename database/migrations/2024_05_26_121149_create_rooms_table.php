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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->string('room_no',20);

            $table->unsignedBigInteger('roomtype_id');
            $table->foreign('roomtype_id')->references('id')->on('roomtypes')->onDelete('restrict')->onUpdate('cascade');
            $table->string('room_floor',20)->nullable()->default('NA');
            $table->string('room_facilities',100)->nullable()->default('NA');
            $table->string('room_image1',300)->nullable()->default('NA');
            $table->string('room_image2',300)->nullable()->default('NA');
            $table->string('room_image3',300)->nullable()->default('NA');
            $table->enum('room_status', ['vacant', 'booked', 'occupied', 'dirty'])->default('vacant');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
