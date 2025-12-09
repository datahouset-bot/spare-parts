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
        Schema::create('attendancecheckins', function (Blueprint $table) {
            $table->id();
            // employee details
    $table->unsignedBigInteger('emp_id');
    $table->foreign('emp_id')->references('id')->on('photoattendances')->onDelete('cascade');
    $table->string('emp_name');
    // attendance details
    $table->string('checkin_photo')->nullable();
    $table->string('checkout_photo')->nullable();
    // attendance timestamps
    $table->datetime('checkin_time')->nullable();
    $table->datetime('checkout_time')->nullable();
// additional fields if needed
$table->string('af1')->nullable();
$table->string('af2')->nullable();
$table->string('af3')->nullable();
$table->string('af4')->nullable();
$table->string('af5')->nullable();

    // timestamps
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendancecheck');
    }
};
