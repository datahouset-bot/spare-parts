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
        Schema::create('labelsettings', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id', 100);
            $table->string('field_name', 100); // example: batch_no
            $table->string('replaced_field_name', 100)->nullable(); // example: Size, Weight
            $table->boolean('is_visible')->default(1); // true(1) = visible, false(0) = hidden
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labelsettings');
    }
};
