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
        Schema::create('gstmasters', function (Blueprint $table) {
            $table->id();
            $table->string('taxname',50);
            $table->decimal('sgst', 8, 4)->nullable()->default(0.0000);
            $table->decimal('cgst', 8, 4)->nullable()->default(0.0000);
            $table->decimal('igst', 8, 4)->nullable()->default(0.0000);            $table->decimal('vat', 8, 4)->nullable()->default(0.0000);            $table->decimal('tax1', 8, 4)->nullable()->default(0.0000);
            $table->decimal('tax2', 8, 4)->nullable()->default(0.0000);            $table->decimal('tax3', 8, 4)->nullable()->default(0.0000);            $table->decimal('tax4', 8, 4)->nullable()->default(0.0000);            $table->decimal('tax5', 8, 4)->nullable()->default(0.0000);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gstmasters');
    }
};
