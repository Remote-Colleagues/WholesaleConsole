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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->nullable()->after('id'); // Add partner_id column
            $table->unsignedBigInteger('consoler_id')->nullable()->change();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('consoler_id')->nullable(false)->change();
            $table->dropForeign(['partner_id']);
            $table->dropColumn('partner_id');
        });
    }
};
