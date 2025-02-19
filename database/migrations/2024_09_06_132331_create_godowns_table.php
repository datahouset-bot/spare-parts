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
        Schema::create('godowns', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->string('godown_name');
            $table->string('godown_address')->nullable();
            $table->string('godown_af1')->nullable();
            $table->string('godown_af2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('godowns');
    }
};
