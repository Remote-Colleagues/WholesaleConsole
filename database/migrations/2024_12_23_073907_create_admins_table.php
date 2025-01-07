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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->float('contact_person')->nullable();
            $table->float('contact_phone_number')->nullable();
            $table->text('terms_conditions_wc_partners')->nullable();
            $table->text('terms_conditions_wc_consolers')->nullable();
            $table->text('privacy_policy_for_all');
            $table->float('abn_number')->nullable();
            $table->string('banking_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
