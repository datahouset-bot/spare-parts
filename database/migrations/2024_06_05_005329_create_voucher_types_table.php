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
        Schema::create('voucher_types', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type_name');
            $table->integer('numbring_start_from')->nullable()->default('0');
            $table->string('voucher_prefix')->nullable();
            $table->string('voucher_suffix')->nullable();
            $table->string('voucher_numbring_style')->nullable();
            $table->string('voucher_print_name')->nullable();
            $table->text('voucher_remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_types');
    }
};
