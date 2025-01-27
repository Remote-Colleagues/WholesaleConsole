<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('master_agreement_for_wconsoler')->nullable();
            $table->string('master_agreement_for_partners')->nullable();
            $table->string('bsb_number')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn([
                'master_agreement_for_wconsoler',
                'master_agreement_for_partners',
                'bsb_number',
            ]);
        });
    }

};
