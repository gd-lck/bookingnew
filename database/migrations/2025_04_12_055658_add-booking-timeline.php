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
        Schema::table('bookings', function (Blueprint $table){
            $table->time('booking_start')->after('booking_time');
            $table->time('booking_end')->after('booking_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table){
            $table->dropColumn('booking_start');
            $table->dropColumn('booking_end');
        });
    }
};
