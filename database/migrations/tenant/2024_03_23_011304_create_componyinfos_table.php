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
        Schema::create('componyinfos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('cominfo_firm_name', 150);   
            $table->string('cominfo_address1', 150)->nullable();
            $table->string('cominfo_address2', 150)->nullable();
            $table->string('cominfo_city', 100)->nullable();
            $table->string('cominfo_pincode', 20)->nullable();
            $table->string('cominfo_state', 100)->nullable();
            $table->string('cominfo_phone', 40)->nullable();
            $table->string('cominfo_mobile', 40)->nullable();
            $table->string('cominfo_email', 40)->nullable();
            $table->string('cominfo_gst_no', 40)->nullable();
            $table->string('cominfo_pencard', 40)->nullable();
            $table->string('cominfo_field1', 40)->nullable();
            $table->string('cominfo_field2', 40)->nullable();



       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('componyinfos');
    }
};
