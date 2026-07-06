<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('updated_by')->nullable(); 

            $table->string('kode_barang')->nullable(); 
            $table->string('nama_barang');
            $table->integer('stok')->default(0);
            $table->string('satuan')->nullable();
            $table->decimal('harga', 12, 2);
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};