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
        schema::create('karyawans', function (Blueprint $table){
            $table -> id();
            $table -> string('nama');
            $table -> string('email')->unique();
            $table -> string('status_kerja');
            $table -> timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('karyawans');
    }
};
