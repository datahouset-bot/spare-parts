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
            $table->timestamps();
            $table->string('bank_name',20)->nullable();
            $table->string('bank_ac_no',20)->nullable();
            $table->string('bank_ifsc',20)->nullable();
            $table->string('upiid',20)->nullable();
            $table->string('pay_no',20)->nullable();
            $table->string('bank_branch',20)->nullable();
            $table->string('voucher_prefix',20)->nullable();
            $table->string('voucher_suffix',20)->nullable();
            $table->string('voucher_note',100)->nullable();
            $table->string('country',20)->nullable();
            $table->string('currency',20)->nullable();
            $table->string('terms',300)->nullable();
            $table->string('ct1',30)->nullable();
            $table->string('ct2',30)->nullable();
            $table->string('ct3',30)->nullable();
            $table->string('ct4',30)->nullable();
            $table->string('ct5',30)->nullable();
            $table->string('ct6',30)->nullable();
            $table->string('ct7',30)->nullable();
            $table->string('ct8',30)->nullable();
            $table->string('ct9',30)->nullable();
            
            
            
            
            

            
            
            
            
            
            
                   
            
       
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
