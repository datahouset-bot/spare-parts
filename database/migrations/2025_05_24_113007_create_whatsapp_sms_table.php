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
    Schema::create('whatsapp_sms', function (Blueprint $table) {
        $table->id();
        $table->string('firm_id')->nullable();
        $table->string('transection_type')->nullable();
        $table->text('wp_message')->nullable();
        $table->text('text_message')->nullable();
        $table->boolean('wp_active')->default(false);
        $table->boolean('sms_active')->default(false);
        $table->string('sms_template_id')->nullable();
        
        // Additional fields af1 to af10
        $table->string('af1')->nullable();
        $table->string('af2')->nullable();
        $table->string('af3')->nullable();
        $table->string('af4')->nullable();
        $table->string('af5')->nullable();
        $table->string('af6')->nullable();
        $table->string('af7')->nullable();
        $table->string('af8')->nullable();
        $table->string('af9')->nullable();
        $table->string('af10')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_sms');
    }
};
