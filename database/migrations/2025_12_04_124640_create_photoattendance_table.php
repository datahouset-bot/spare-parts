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
        Schema::create('photoattendances', function (Blueprint $table) {
            $table->id()->autoIncrement();

              // Left column
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->text('address');
            $table->string('document_no');
            // Right column
            $table->string('photo')->nullable();
            $table->decimal('salary_amount', 10, 2)->nullable();
            $table->string('date_of_joining')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_submit')->nullable();

            //term and condition
            $table->text('terms_text')->nullable();
            $table->boolean('terms')->default(false);

            //system fields
            $table->timestamps();

            // Add any additional fields as necessary
            $table->string('Report_time')->nullable();
            $table->string('Buffer_time')->nullable();
            $table->string('advance_salary')->nullable();
            $table->string('advance_date')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('designation')->nullable();      
    

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photoattendance');
    }
};
