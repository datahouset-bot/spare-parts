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
        Schema::create('compinfofooters', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->timestamps();
            $table->string('bank_name',100)->nullable();
            $table->string('bank_ac_no',100)->nullable();
            $table->string('bank_ifsc',100)->nullable();
            $table->string('upiid',100)->nullable();
            $table->string('pay_no',100)->nullable();
            $table->string('bank_branch',100)->nullable();
            $table->string('voucher_prefix',100)->nullable();
            $table->string('voucher_suffix',100)->nullable();
            $table->string('voucher_note',100)->nullable();
            $table->string('country',100)->nullable();
            $table->string('currency',100)->nullable();
            $table->string('terms',300)->nullable();
            $table->string('ct1',100)->nullable();
            $table->string('ct2',100)->nullable();
            $table->string('ct3',100)->nullable();
            $table->string('ct4',200)->nullable();
            $table->string('ct5',100)->nullable();
            $table->string('ct6',100)->nullable();
            $table->string('ct7',100)->nullable();
            $table->string('ct8',100)->nullable();
            $table->string('ct9',100)->nullable();
            
            
            
            
            

            
            
            
            
            
            
                   
            
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compinfofooters');
    }
};
