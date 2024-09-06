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
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('itemgroups')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict')->onUpdate('cascade');

            $table->unsignedBigInteger('item_gst_id');
            $table->foreign('item_gst_id')->references('id')->on('gstmasters');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');

       
            $table->decimal('sale_rate_a', 8, 2)->default(0)->nullable();
            $table->decimal('sale_rate_b', 8, 2)->default(0)->nullable();
            $table->decimal('sale_rate_c', 8, 2)->default(0)->nullable();
            $table->decimal('purchase_rate', 8, 2)->default(0)->nullable();
            $table->string('item_barcode')->nullable()->default(0);
            $table->string('item_image')->nullable()->default(Null);
            $table->string('item_unit')->nullable()->default(Null);
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['group_id']);
            $table->dropForeign(['company_id']);
            $table->dropForeign(['item_gst_id']);
            $table->dropForeign(['unit_id']);
            
            // Drop columns
            $table->dropColumn(['group_id', 'company_id', 'item_gst_id', 'unit_id']);
            $table->dropColumn(['sale_rate_a', 'sale_rate_b', 'sale_rate_c', 'purchase_rate']);
            $table->dropColumn(['item_barcode', 'item_image','item_unit']);
            $table->timestamps();
        });
    }
    
};
