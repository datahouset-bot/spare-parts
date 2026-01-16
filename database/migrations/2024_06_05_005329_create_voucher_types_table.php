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
            $table->string('firm_id',100);
            $table->string('voucher_type_name');
            $table->integer('numbring_start_from')->nullable()->default('0');
            $table->string('voucher_prefix')->nullable();
            $table->string('voucher_suffix')->nullable();
            $table->string('voucher_numbring_style')->nullable();
            $table->string('voucher_print_name')->nullable();
            $table->text('voucher_remark')->nullable();
            $table->string('voucher_af1')->nullable();
            $table->string('voucher_af2')->nullable();
            $table->string('voucher_af3')->nullable();  
            $table->string('voucher_af4')->nullable();
            $table->string('voucher_af5')->nullable();
            $table->string('voucher_af6')->nullable();
            $table->string('voucher_af7')->nullable();
            $table->string('voucher_af8')->nullable();
            $table->string('voucher_af9')->nullable();
            $table->string('voucher_af10')->nullable();
            $table->string('voucher_af11')->nullable();
            $table->string('voucher_af12')->nullable();
            $table->string('voucher_af13')->nullable();
            $table->string('voucher_af14')->nullable();
            $table->string('voucher_af15')->nullable();

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
