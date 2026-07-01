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
        Schema::create('stok_keluars', function (Blueprint $table) {

            $table->id();

            // Relasi ke tabel products
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Jumlah barang keluar
            $table->integer('jumlah');

            // Tanggal barang keluar
            $table->date('tanggal');

            // Tujuan barang keluar
            $table->string('tujuan')->nullable();

            // Keterangan
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_keluars');
    }
};