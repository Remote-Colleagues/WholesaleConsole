<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name');
            $table->bigInteger('contact_person')->nullable();
            $table->bigInteger('contact_phone_number')->nullable();
            $table->text('your_agreement')->nullable();
            $table->bigInteger('abn_number')->nullable();
            $table->text('operation_location')->nullable();
            $table->date('billing_commencement_date')->nullable();
            $table->bigInteger('establishment_fee')->nullable();
            $table->bigInteger('monthly_subscription_fee')->nullable();
            $table->bigInteger('csvusernumber')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
