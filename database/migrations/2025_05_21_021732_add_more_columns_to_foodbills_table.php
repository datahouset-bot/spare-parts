<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToFoodbillsTable extends Migration
{
    public function up()
    {
        Schema::table('foodbills', function (Blueprint $table) {
            $table->string('firm_name')->nullable()->after('foodbill_af5');
            $table->string('gst_no')->nullable()->after('firm_name');
            $table->string('bill_type')->nullable()->after('gst_no');

            // Add foodbill_af6 to foodbill_af15
            $table->string('foodbill_af6')->nullable()->after('foodbill_af5');
            $table->string('foodbill_af7')->nullable()->after('foodbill_af6');
            $table->string('foodbill_af8')->nullable()->after('foodbill_af7');
            $table->string('foodbill_af9')->nullable()->after('foodbill_af8');
            $table->string('foodbill_af10')->nullable()->after('foodbill_af9');
            $table->string('foodbill_af11')->nullable()->after('foodbill_af10');
            $table->string('foodbill_af12')->nullable()->after('foodbill_af11');
            $table->string('foodbill_af13')->nullable()->after('foodbill_af12');
            $table->string('foodbill_af14')->nullable()->after('foodbill_af13');
            $table->string('foodbill_af15')->nullable()->after('foodbill_af14');
        });
    }

    public function down()
    {
        Schema::table('foodbills', function (Blueprint $table) {
            $table->dropColumn([
                'firm_name',
                'gst_no',
                'bill_type',
                'foodbill_af6',
                'foodbill_af7',
                'foodbill_af8',
                'foodbill_af9',
                'foodbill_af10',
                'foodbill_af11',
                'foodbill_af12',
                'foodbill_af13',
                'foodbill_af14',
                'foodbill_af15',
            ]);
        });
    }
}
