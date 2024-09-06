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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
          

            $table->string('lead_title')->nullable();
            $table->string('lead_name')->nullable();
            $table->string('lead_mobile')->nullable();
            $table->string('lead_city')->nullable();
            $table->string('lead_product')->nullable();
            $table->string('lead_disc')->nullable();
            $table->string('lead_executive')->nullable();
            $table->string('lead_af1')->default('0');
            $table->string('lead_af2')->default('0');
            $table->string('lead_af3')->default('0');
            $table->string('lead_af4')->default('0');
            $table->string('lead_af5')->default('0');
            $table->string('lead_af6')->default('0');
            $table->string('lead_af7')->default('0');
          
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
