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
        Schema::create('nilai_lomba', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->bigInteger('id_juri')->unsigned();
            $table->bigInteger('id_kategori_penilaian')->unsigned();
            $table->integer('poin_nilai');
            $table->bigInteger('id_tim')->unsigned();
            $table->integer('poin_nilai_lomba');
            $table->foreign('id_juri')
                ->references('id_juri')
                ->on('juri')->cascadeOnDelete();
            $table->foreign('id_kategori_penilaian')
                ->references('id_kategori')
                ->on('kategori_penilaian')->cascadeOnDelete();
            $table->foreign('id_tim')
                ->references('id_tim')
                ->on('tim')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_lomba');
    }
};
