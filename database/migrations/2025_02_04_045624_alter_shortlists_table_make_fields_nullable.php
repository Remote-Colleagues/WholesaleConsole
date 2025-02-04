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
        Schema::table('shortlists', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('make')->nullable()->change();
            $table->string('model')->nullable()->change();
            $table->string('build_date')->nullable()->change();
            $table->integer('odometer')->nullable()->change();
            $table->string('body_type')->nullable()->change();
            $table->string('fuel')->nullable()->change();
            $table->string('transmission')->nullable()->change();
            $table->integer('seats')->nullable()->change();
            $table->string('auctioneer')->nullable()->change();
            $table->string('link_to_auction')->nullable()->change();
            $table->text('other_specs')->nullable()->change();
            $table->string('unique_identifier')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('vin')->nullable()->change();
            $table->integer('hours')->nullable()->change();
            $table->timestamp('deadline')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shortlists', function (Blueprint $table) {
            // Remove nullable constraints if rolling back
            $table->string('name')->nullable(false)->change();
            $table->string('make')->nullable(false)->change();
            $table->string('model')->nullable(false)->change();
            $table->string('build_date')->nullable(false)->change();
            $table->integer('odometer')->nullable(false)->change();
            $table->string('body_type')->nullable(false)->change();
            $table->string('fuel')->nullable(false)->change();
            $table->string('transmission')->nullable(false)->change();
            $table->integer('seats')->nullable(false)->change();
            $table->string('auctioneer')->nullable(false)->change();
            $table->string('link_to_auction')->nullable(false)->change();
            $table->text('other_specs')->nullable(false)->change();
            $table->string('unique_identifier')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('vin')->nullable(false)->change();
            $table->integer('hours')->nullable(false)->change();
            $table->timestamp('deadline')->nullable(false)->change();
        });
    }
};
