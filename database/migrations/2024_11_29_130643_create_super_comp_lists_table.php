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
        Schema::create('super_comp_lists', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id', 50)->unique(); // Reduced length for firm_id
            $table->string('firm_name', 300)->unique();
            $table->string('firm_mobile', 15); // Adjusted length for mobile numbers
            $table->string('firm_dealer', 200);
            $table->date('activation_date');
            $table->date('expiry_date'); // Corrected spelling
            $table->decimal('billing_amt', 10, 2); 
            // Changed to decimal for storing amounts
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_comp_lists');
    }
};
