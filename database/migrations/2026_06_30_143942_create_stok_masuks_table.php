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
        Schema::create('stok_masuks', function (Blueprint $table) {

            $table->id();

            // Relasi ke tabel products
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Jumlah barang masuk
            $table->integer('jumlah');

            // Tanggal barang masuk
            $table->date('tanggal');

            // Nama supplier
            $table->string('supplier')->nullable();

            // Keterangan tambahan
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_masuks');
    }
};