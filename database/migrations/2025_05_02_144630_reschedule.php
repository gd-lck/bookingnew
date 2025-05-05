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
        Schema::create('reschedules', function (Blueprint $table){
            $table->id();
            $table->foreignId('id_booking')->constrained('bookings')->onDelete('cascade');;
            $table->dateTime('jadwal_awal')->nullable();
            $table->dateTime('jadwal_baru')->nullable();
            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reschedules');
    }
};
