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
        Schema::create('lomba', function (Blueprint $table) {
            $table->id('id_lomba');
            $table->string('nama_lomba', 50);
            $table->integer('anggota_tim_minimal');
            $table->integer('anggota_tim_maksimal');
            $table->integer('jumlah_juri');
            $table->bigInteger('id_nomor_perlombaan')->unsigned();
            $table->foreign('id_nomor_perlombaan')
                ->references('id_nomor_perlombaan')
                ->on('nomor_perlombaan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lomba');
    }
};
