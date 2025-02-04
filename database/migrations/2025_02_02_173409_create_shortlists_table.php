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
        Schema::create('shortlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('auction_id')->constrained()->onDelete('cascade');
            
            // Store auction details here
            $table->string('name');
            $table->string('make');
            $table->string('model');
            $table->string('build_date');
            $table->integer('odometer');
            $table->string('body_type');
            $table->string('fuel');
            $table->string('transmission');
            $table->integer('seats');
            $table->string('auctioneer');
            $table->string('link_to_auction');
            $table->text('other_specs');
            $table->string('unique_identifier');
            $table->string('state');
            $table->string('vin');
            $table->integer('hours');
            $table->timestamp('deadline');
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortlists');
    }
};
