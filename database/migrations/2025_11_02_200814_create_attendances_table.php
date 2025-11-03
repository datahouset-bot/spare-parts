<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->string('firm_id',100);

        $table->unsignedBigInteger('user_id');
        $table->date('attendance_date');
        $table->string('status')->default('P'); // P = Present, A = Absent, H = Half Day
        $table->time('in_time')->nullable();
        $table->time('out_time')->nullable();
        $table->string('attend_af1')->nullable();
        $table->string('attend_af2')->nullable();
        $table->string('attend_af3')->nullable();   
        $table->string('attend_af4')->nullable();
        $table->string('attend_af5')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
public function down()
{
    Schema::dropIfExists('attendances');
}

};
