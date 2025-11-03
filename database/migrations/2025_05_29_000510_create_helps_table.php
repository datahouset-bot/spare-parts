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
        Schema::create('helps', function (Blueprint $table) {
            $table->id();
        $table->string('business_type')->nullable();
        $table->string('type')->nullable();
        $table->string('topic')->nullable();
        $table->string('url')->nullable();
        $table->text('description')->nullable();
        
        // Additional custom fields
        $table->string('help_af1')->nullable();
        $table->string('help_af2')->nullable();
        $table->string('help_af3')->nullable();
        $table->string('help_af4')->nullable();
        $table->string('help_af5')->nullable();
        $table->string('help_af6')->nullable();
        $table->string('help_af7')->nullable();
        $table->string('help_af8')->nullable();
        $table->string('help_af9')->nullable();
        $table->string('help_af10')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helps');
    }
};
