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
        Schema::create('othercharges', function (Blueprint $table) {
            $table->id();
            $table->string('charge_name');
            $table->string('charge_type');
            $table->string('input_type');
            $table->string('applicable_on');
            $table->unsignedBigInteger('charge_posting_account');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('charge_posting_account')
                  ->references('id')
                  ->on('accounts')
                  ->onDelete('restrict');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('othercharges', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['charge_posting_account']);
        });
        Schema::dropIfExists('othercharges');
    }
};
