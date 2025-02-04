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
            $table->string('odometer', 255)->nullable()->change(); // Change to VARCHAR(255)
            $table->string('seats', 255)->nullable()->change(); // Change to VARCHAR(255)
            $table->string('deadline', 255)->nullable()->change(); // Change to VARCHAR(255)
            $table->string('hours', 255)->nullable()->change(); // Change to VARCHAR(255)
            $table->date('build_date')->nullable()->change(); // Change to DATE format

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shortlists', function (Blueprint $table) {
            $table->string('build_date', 255)->nullable()->change(); // Revert back to string if needed
            $table->integer('odometer')->nullable()->change(); // Revert to integer if needed
            $table->integer('seats')->nullable()->change(); // Revert to integer if needed
            $table->timestamp('deadline')->nullable()->change(); // Revert back to timestamp
            $table->integer('hours')->nullable()->change(); // Revert to integer if needed
        });
    }
};
