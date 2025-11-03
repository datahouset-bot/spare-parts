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
        Schema::table('roomcheckins', function (Blueprint $table) {
            $table->string('checkinaf6')->nullable()->after('checkinaf5');
            $table->string('checkinaf7')->nullable();
            $table->string('checkinaf8')->nullable();
            $table->string('checkinaf9')->nullable();
            $table->string('checkinaf10')->nullable();
            $table->string('checkinaf11')->nullable();
            $table->string('checkinaf12')->nullable();
            $table->string('checkinaf13')->nullable();
            $table->string('checkinaf14')->nullable();
            $table->string('checkinaf15')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roomcheckins', function (Blueprint $table) {
            $table->dropColumn([
                'checkinaf6', 'checkinaf7', 'checkinaf8', 'checkinaf9', 
                'checkinaf10', 'checkinaf11', 'checkinaf12', 'checkinaf13', 
                'checkinaf14', 'checkinaf15'
            ]);
            //
        });
    }
};
