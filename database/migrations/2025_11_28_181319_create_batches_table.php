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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id', 100);
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            
            $table->string('batch_no', 100)->nullable();
            $table->string('batch_af1', 50)->nullable();
            $table->string('batch_af2', 50)->nullable();
            $table->string('batch_af3', 50)->nullable();
            $table->string('batch_af4', 50)->nullable();
            $table->string('batch_af5', 50)->nullable();
            
            $table->date('mfg_date')->nullable();
            $table->date('exp_date')->nullable();
            
            $table->string('batch_mrp', 50)->nullable();
            $table->string('batch_sale_rate', 50)->nullable();
            $table->string('batch_basic_rate', 50)->nullable();
            $table->string('batch_a_rate', 50)->nullable();
            $table->string('batch_b_rate', 50)->nullable();
            $table->string('batch_c_rate', 50)->nullable();
            $table->string('batch_purchase_rate', 50)->nullable();
            $table->string('batch_op_qty', 50)->nullable();
            $table->string('batch_op_value', 50)->nullable();
            $table->string('batch_barcode', 80)->nullable();
            
            // Corrected this to use string instead of text and removed length from text
            $table->string('batch_op_remark', 100)->nullable(); 
            
            $table->string('rack', 50)->nullable(); // Added nullable to match the rest
            
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
