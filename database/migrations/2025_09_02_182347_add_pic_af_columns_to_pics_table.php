<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pics', function (Blueprint $table) {
            $previous = 'brand'; // start after brand
            for ($i = 1; $i <= 20; $i++) {
                $column = 'pic_af' . $i;
                $table->text($column)->nullable()->after($previous);
                $previous = $column; // chain columns in correct order
            }
        });
    }

    public function down(): void
    {
        Schema::table('pics', function (Blueprint $table) {
            for ($i = 1; $i <= 20; $i++) {
                $table->dropColumn('pic_af' . $i);
            }
        });
    }
};
