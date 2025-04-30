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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->dateTime('booking_time');
            $table->enum('status', [ 'pending','canceled','booked', 'rescheduled'])->default('booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
