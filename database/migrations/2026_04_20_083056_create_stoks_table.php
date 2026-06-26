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
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang'); // HAPUS ->after('id') nya, cukup begini saja
            $table->string('nama_barang');
            $table->integer('stok');
            $table->decimal('harga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jangan lupa ganti juga di bagian drop agar sinkron
        Schema::dropIfExists('stoks');
    }
};