<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom yang kurang tanpa menghapus data lama
            if (!Schema::hasColumn('products', 'kode_barang')) {
                $table->string('kode_barang', 50)->nullable()->after('id');
            }
            if (!Schema::hasColumn('products', 'satuan')) {
                $table->string('satuan', 50)->nullable()->after('nama_barang');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['kode_barang', 'satuan']);
        });
    }
};