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
        schema::create('payment_gateways', function (Blueprint $table){
           $table -> id();
           $table -> string('provider');
           $table -> string('payment_type');
           $table -> string('va_number');
           $table -> string('snap_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('payment_gateways');
    }
};
