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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();

            $table->date('reminder_date');
            $table->string('reminder_title')->nullable();
            $table->string('reminder_name')->nullable();
            $table->string('reminder_mobile')->nullable();
            $table->string('reminder_city')->nullable();
            $table->string('reminder_disc')->nullable();
            $table->string('reminder_af1')->default('0');
            $table->string('reminder_af2')->nullable();
            $table->string('reminder_af3')->nullable();
            $table->string('reminder_af4')->nullable();
            $table->string('reminder_af5')->nullable();
            $table->string('reminder_af6')->nullable();
            $table->string('reminder_af7')->nullable();
            $table->string('reminder_af8')->nullable();
            $table->string('reminder_af9')->nullable();            
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
