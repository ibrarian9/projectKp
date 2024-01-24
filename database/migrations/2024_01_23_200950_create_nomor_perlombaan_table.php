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
        Schema::create('nomor_perlombaan', function (Blueprint $table) {
            $table->id('id_nomor_perlombaan');
            $table->integer('kategori_gender');
            $table->string('nomor_lomba', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_perlombaan');
    }
};
