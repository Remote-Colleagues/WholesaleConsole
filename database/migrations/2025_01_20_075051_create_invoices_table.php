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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('date_created');
            $table->string('invoice_number')->unique();
            $table->string('consoler_name');
            $table->bigInteger('amount');
            $table->enum('status', ['Pending', 'Paid', 'hide']);
            $table->unsignedBigInteger('consoler_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('consoler_id')->references('id')->on('consolers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
