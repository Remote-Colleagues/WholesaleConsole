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
        Schema::create('transport_calculator', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('per_km_charge')->nullable();
            $table->bigInteger('same_state_charge')->nullable();
            $table->bigInteger('cross_state_charge')->nullable();
            $table->bigInteger('additional_charges')->nullable();
            $table->bigInteger('additional_charge_for_size')->nullable();
            $table->string('body_type')->nullable();
            $table->integer('categories')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_calculator');
    }
};
