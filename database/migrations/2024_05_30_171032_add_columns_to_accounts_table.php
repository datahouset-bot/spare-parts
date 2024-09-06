<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('pincode')->nullable()->default('0')->after('gst_no'); // Replace 'existing_column' with the column after which these new columns should be added
            $table->string('nationality')->nullable()->default('0')->after('pincode');
            $table->string('address2')->nullable()->default('0')->after('nationality');
            $table->string('pen_card')->nullable()->default('0')->after('address2');
            $table->string('account_idproof_name')->nullable()->default('0')->after('pen_card');
            $table->string('account_idproof_no')->nullable()->default('0')->after('account_idproof_name');
            $table->string('account_id_pic')->nullable()->default('0')->after('account_idproof_no');
            $table->string('account_pic1')->nullable()->default('0')->after('account_id_pic');
            $table->string('account_attachment1')->nullable()->default('0')->after('account_pic1');
            $table->string('account_route')->nullable()->default('0')->after('account_attachment1');
            $table->string('account_salsman')->nullable()->default('0')->after('account_route');
            $table->string('account_cr_days')->nullable()->default('0')->after('account_salsman');
            $table->string('account_birthday')->nullable()->default('0')->after('account_cr_days');
            $table->string('account_anniversary')->nullable()->default('0')->after('account_birthday');
            $table->string('account_code')->nullable()->default('0')->after('account_anniversary');
            $table->string('gst_code')->nullable()->default('0')->after('account_code');
            
            $table->string('account_dl1')->nullable()->default('0')->after('gst_code');
            $table->string('account_dl2')->nullable()->default('0')->after('account_dl1');
            $table->string('account_af1')->nullable()->default('0')->after('account_dl2');
            $table->string('account_af2')->nullable()->default('0')->after('account_af1');
            $table->string('account_af3')->nullable()->default('0')->after('account_af2');
            $table->string('account_af4')->nullable()->default('0')->after('account_af3');
            $table->string('account_af5')->nullable()->default('0')->after('account_af4');
            $table->string('account_af6')->nullable()->default('0')->after('account_af5');
            $table->string('account_af7')->nullable()->default('0')->after('account_af6');
            $table->string('account_af8')->nullable()->default('0')->after('account_af7');
            $table->string('account_af9')->nullable()->default('0')->after('account_af8');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn([
                'pincode',
                'nationality',
                'address2',
                'pen_card',
                'account_idproof_name',
                'account_idproof_no',
                'account_id_pic',
                'account_pic1',
                'account_attachment1',
                'account_route',
                'account_salsman',
                'account_cr_days',
                'account_birthday',
                'account_anniversary',
                'account_code',
                'gst_code',
                'account_dl1',
                'account_dl2',
                'account_af1',
                'account_af2',
                'account_af3',
                'account_af4',
                'account_af5',
                'account_af6',
                'account_af7',
                'account_af8',
                'account_af9',
            ]);
        });
    }
}
