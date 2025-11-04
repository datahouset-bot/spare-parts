<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('componyinfos', function (Blueprint $table) {
            $table->boolean('gst_notapplicable')->nullable();
            $table->boolean('make_all_bill_local_gst')->nullable();
            
                $table->string("componyinfo_af1")->nullable();
                $table->string("componyinfo_af2")->nullable();
                $table->string("componyinfo_af3")->nullable(); 
                $table->string("componyinfo_af4")->nullable();
                $table->string("componyinfo_af5")->nullable();
                $table->string("componyinfo_af6")->nullable(); 
                $table->string("componyinfo_af7")->nullable();
                $table->string("componyinfo_af9")->nullable();
                $table->string("componyinfo_af9")->nullable();
                $table->string("componyinfo_af10",500)->nullable(); 
            
            });
    }

    public function down(): void
    {
        Schema::table('componyinfos', function (Blueprint $table) {
            $table->dropColumn('gst_notapplicable');
            $table->dropColumn('make_all_bill_local_gst');
            for ($i = 1; $i <= 10; $i++) {
                $table->dropColumn("componyinfo_af$i");
            }
        });
    }
};
