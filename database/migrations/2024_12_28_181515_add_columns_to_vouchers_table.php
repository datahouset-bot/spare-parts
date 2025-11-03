<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations — add columns to vouchers table.
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->text('voucher_terms')->nullable()->after('total_net_amount');
            $table->text('voucher_remark')->nullable()->after('voucher_terms');
            $table->string('voucher_af1')->nullable()->after('voucher_remark');
            $table->string('voucher_af2')->nullable();
            $table->string('voucher_af3')->nullable();
            $table->string('voucher_af4')->nullable();
            $table->string('voucher_af5')->nullable();
            $table->string('voucher_af6')->nullable();
            $table->string('voucher_af7')->nullable();
            $table->string('voucher_af8')->nullable();
            $table->string('voucher_af9')->nullable();
            $table->string('voucher_af10')->nullable();
            $table->string('voucher_af11')->nullable();
            $table->string('voucher_af12')->nullable();
            $table->string('voucher_af13')->nullable();
            $table->string('voucher_af14')->nullable();
            $table->string('voucher_af15')->nullable();
            $table->string('transport')->nullable();
            $table->string('gr_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('station')->nullable();
            $table->string('fright')->nullable();
        });
    }

    /**
     * Reverse the migrations — remove added columns.
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn([
                'voucher_terms',
                'voucher_remark',
                'voucher_af1',
                'voucher_af2',
                'voucher_af3',
                'voucher_af4',
                'voucher_af5',
                'voucher_af6',
                'voucher_af7',
                'voucher_af8',
                'voucher_af9',
                'voucher_af10',
                'voucher_af11',
                'voucher_af12',
                'voucher_af13',
                'voucher_af14',
                'voucher_af15',
                'transport',
                'gr_no',
                'vehicle_no',
                'station',
                'fright',
            ]);
        });
    }
};
