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
        Schema::create('foto_produk', function (Blueprint $table) {
            $table->id('id_foto');
            $table->foreignId('id_produk');
            $table->string('url_foto');

            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
