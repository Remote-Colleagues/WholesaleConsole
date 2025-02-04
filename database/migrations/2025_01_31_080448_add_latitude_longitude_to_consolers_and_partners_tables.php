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
        // Add latitude and longitude to consolers table
        Schema::table('consolers', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('post_code');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });

        // Add latitude and longitude to partners table
        Schema::table('partners', function (Blueprint $table) {
            $table->string('latitude', 1000)->nullable()->after('operation_location');
            $table->string('longitude', 1000)->nullable()->after('latitude');
            $table->string('premium_charged', 1000)->nullable()->after('longitude');

        });
    }

    public function down()
    {
        // Remove latitude and longitude if rolling back
        Schema::table('consolers', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }

};
