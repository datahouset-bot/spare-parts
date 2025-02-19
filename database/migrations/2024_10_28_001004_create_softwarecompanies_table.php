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
        Schema::create('softwarecompanies', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
          
            $table->date('activation_date')->nullable();
            $table->date('expiry_date')->nullable(); // Corrected spelling
            
            $table->string('customer_firm_name', 150)->nullable();
            $table->string('customer_mobile', 15)->nullable(); // Adjusted length
            $table->string('customer_phone', 15)->nullable();  // Adjusted length
            $table->string('software_firm_name', 150)->nullable();
            $table->string('software_address1', 150)->nullable();
            $table->string('software_address2', 150)->nullable();
            $table->string('software_city', 100)->nullable();
            $table->string('software_pincode', 10)->nullable(); // Adjusted length
            $table->string('software_state', 100)->nullable();
            $table->string('software_phone', 15)->nullable();  // Adjusted length
            $table->string('software_mobile', 15)->nullable(); // Adjusted length
            $table->string('software_email', 100)->nullable();
            $table->string('software_website', 200)->nullable(); // Adjusted length for URLs
            $table->string('software_facebook', 200)->nullable(); // Adjusted length for URLs
            $table->string('software_youtube', 200)->nullable(); // Adjusted length for URLs
            $table->string('software_twitter', 200)->nullable(); // Corrected spelling
            $table->string('software_logo1', 400)->nullable();
            $table->string('software_logo2', 400)->nullable();
            $table->string('software_logo3', 400)->nullable();
            $table->string('software_logo4', 400)->nullable();
            $table->string('software_af1', 100)->nullable();
            $table->string('software_af2', 100)->nullable();
            $table->string('software_af3', 100)->nullable();
            $table->string('software_af4', 100)->nullable();
            $table->string('software_af5', 100)->nullable();
            $table->string('software_af6', 100)->nullable();
            $table->string('software_af7', 100)->nullable();
            $table->string('software_af8', 100)->nullable();
            $table->string('software_af9', 100)->nullable();
            $table->string('software_af10', 100)->nullable();
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('softwarecompanies');
    }
};
