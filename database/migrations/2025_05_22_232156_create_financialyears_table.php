<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financialyears', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id');
            $table->string('financial_year');
            $table->date('financial_year_start');
            $table->date('financial_year_end');
            $table->boolean('is_active_fy')->default(false);
            for ($i = 1; $i <= 5; $i++) {
                $table->string("financialyear_af$i")->nullable();
            }
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financialyears');
    }
};
