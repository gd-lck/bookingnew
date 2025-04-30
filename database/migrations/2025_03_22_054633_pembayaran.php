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
        Schema::create('pembayarans', function(Blueprint $table){
            $table -> id();
            $table -> unsignedBigInteger('id_layanan');
            $table -> unsignedBigInteger('id_user');
            $table -> unsignedBigInteger('id_paymentgtw');
            $table -> string('status_pembayaran');
            //foreign key
            $table->foreign('id_layanan')->references('id')->on('layanans')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_paymentgtw')->references('id')->on('payment_gateways')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
