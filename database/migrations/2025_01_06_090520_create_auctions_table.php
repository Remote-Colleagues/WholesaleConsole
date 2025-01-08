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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->date('build_date')->nullable();
            $table->string('odometer')->nullable();
            $table->string('body_type')->nullable();
            $table->string('fuel')->nullable();
            $table->string('transmission')->nullable();
            $table->string('seats')->nullable();
            $table->string('auctioneer')->nullable();
            $table->string('deadline')->nullable();
            $table->string('link_to_auction')->nullable();
            $table->string('link_to_condition_report')->nullable();
            $table->text('other_specs')->nullable();
            $table->string('unique_identifier')->nullable();
            $table->string('hours')->nullable();
            $table->string('state')->nullable();
            $table->string('redbook_code')->nullable();
            $table->string('redbook_average_wholesale')->nullable();
            $table->string('current_market_retail')->nullable();
            $table->string('auction_registration_link')->nullable();
            $table->string('vin')->nullable();
            $table->date('date_listed')->nullable();
            $table->string('name_of_auction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
