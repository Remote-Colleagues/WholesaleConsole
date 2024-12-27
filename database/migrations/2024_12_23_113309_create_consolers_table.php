<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsolersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');    
            $table->string('console_name');
            $table->string('contact_person');
            $table->string('contact_phone_number');
            $table->string('abn_number');
            $table->string('building')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('your_agreement'); 
            $table->date('billing_commencement_period');
            $table->string('currency')->default('AUD');
            $table->bigInteger('establishment_fee');  
            $table->date('establishment_fee_date');
            $table->bigInteger('monthly_subscription_fee');  
            $table->date('monthly_subscription_fee_date');
            $table->bigInteger('admin_fee'); 
            $table->date('admin_fee_date');
            $table->bigInteger('comm_charge'); 
            $table->date('comm_charge_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consolers');
    }
}
