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
        Schema::create('tim', function (Blueprint $table) {
            $table->id('id_tim');
            $table->bigInteger('id_peserta')->unsigned();
            $table->bigInteger('id_lomba')->unsigned();
            $table->foreign('id_peserta')
                ->references('id_peserta')
                ->on('peserta')
                ->cascadeOnDelete();
            $table->foreign('id_lomba')
                ->references('id_lomba')
                ->on('lomba')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim');
    }
};
