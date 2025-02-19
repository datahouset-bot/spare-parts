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
        Schema::create('accountgroups', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id',100);
            $table->string('account_group_name');
            $table->unsignedBigInteger('primary_group_id');
            $table->foreign('primary_group_id')->references('id')->on('primarygroups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountgroups');
    }
};
