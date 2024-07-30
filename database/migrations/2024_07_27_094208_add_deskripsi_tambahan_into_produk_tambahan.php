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
        Schema::table('produk_tambahan', function (Blueprint $table) {
          $table->string('deskripsi_tambahan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_tambahan', function (Blueprint $table) {
            $table->dropColumn('deskripsi_tambahan');
        });
    }
};
