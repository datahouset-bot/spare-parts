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
        Schema::create('attendancesalary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')->references('id')->on('photoattendances')->onDelete('cascade');
            $table->string('emp_name');
            $table->string('salary');
               $table->string('date');
            $table->string('advance_salary')->nullable();
            $table->string('no_of_days_worked')->nullable();
            $table->string('remark')->nullable();
             $table->enum('salary_status', ['paid', 'unpaid'])->default('unpaid');
                 $table->string('af1')->nullable();
        $table->string('af2')->nullable();
               $table->string('af3')->nullable();
                      $table->string('af4')->nullable();
                             $table->string('af5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendancesalary');
    }
};
