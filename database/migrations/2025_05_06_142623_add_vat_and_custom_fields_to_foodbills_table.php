<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations — add columns to foodbills.
     */
    public function up(): void
    {
        Schema::table('foodbills', function (Blueprint $table) {
            $table->decimal('vat_percent', 8, 2)->nullable()->after('remark');
            $table->decimal('item_vatamt', 10, 2)->nullable()->after('vat_percent');
            $table->decimal('total_vat', 10, 2)->nullable()->after('item_vatamt');
            $table->decimal('tax1_percent', 8, 2)->nullable()->after('total_vat');
            $table->decimal('total_tax1', 10, 2)->nullable()->after('tax1_percent');
            $table->string('foodbill_af1')->nullable()->after('total_tax1');
            $table->string('foodbill_af2')->nullable()->after('foodbill_af1');
            $table->string('foodbill_af3')->nullable()->after('foodbill_af2');
            $table->string('foodbill_af4')->nullable()->after('foodbill_af3');
            $table->string('foodbill_af5')->nullable()->after('foodbill_af4');
        });
    }

    /**
     * Reverse the migrations — remove added columns.
     */
    public function down(): void
    {
        Schema::table('foodbills', function (Blueprint $table) {
            $table->dropColumn([
                'vat_percent',
                'item_vatamt',
                'total_vat',
                'tax1_percent',
                'total_tax1',
                'foodbill_af1',
                'foodbill_af2',
                'foodbill_af3',
                'foodbill_af4',
                'foodbill_af5',
            ]);
        });
    }
};
