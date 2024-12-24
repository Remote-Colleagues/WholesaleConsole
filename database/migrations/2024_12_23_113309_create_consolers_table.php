<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsolersTable extends Migration
{
    public function up()
    {
        Schema::create('consolers', function (Blueprint $table) {
            $table->id();
            $table->string('wc_consolers_name');
            $table->string('contact_person');
            $table->float('contact_phone_number');
            $table->string('contact_email');
            $table->string('password');
            $table->boolean('your_agreement');
            $table->string('abn_number');
            $table->string('operational_location')->nullable();
            $table->float('comm_charge_for_buyers_connect');
            $table->timestamp('last_changed_comm_charge_for_buyers_connect')->useCurrent();
            $table->float('billing_commencement_period');
            $table->timestamp('last_changed_billing_commencement_period')->useCurrent();
            $table->float('admin_fee_for_buyers_connect');
            $table->float('establishment_fee');
            $table->timestamp('last_changed_establishment_fee')->useCurrent();
            $table->float('ongoing_monthly_subs_fee');
            $table->timestamp('last_changed_ongoing_monthly_subs_fee')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consolers');
    }
}

