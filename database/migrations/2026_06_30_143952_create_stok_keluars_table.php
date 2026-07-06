<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_keluars', function (Blueprint $table) {
            $table->id();

            // Kolom Pelacakan Admin
            $table->unsignedBigInteger('user_id'); 

            // Relasi ke tabel products
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->integer('jumlah');
            $table->date('tanggal');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_keluars');
    }
};