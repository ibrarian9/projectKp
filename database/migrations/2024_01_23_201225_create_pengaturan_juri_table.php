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
        Schema::create('pengaturan_juri', function (Blueprint $table) {
            $table->id('id_pengaturan_juri');
            $table->bigInteger('id_juri')->unsigned();
            $table->bigInteger('id_lomba')->unsigned();
            $table->foreign('id_lomba')
                ->references('id_lomba')
                ->on('lomba')->cascadeOnDelete();
            $table->foreign('id_juri')
                ->references('id_juri')
                ->on('juri')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_juri');
    }
};
