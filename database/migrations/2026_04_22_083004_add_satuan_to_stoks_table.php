<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stoks', function (Blueprint $table) {
        // Menambahkan kolom satuan setelah nama_barang
            $table->string('satuan')->after('nama_barang')->default('pcs');
        });
    }

    public function down(): void
    {
        Schema::table('stoks', function (Blueprint $table) {
            $table->dropColumn('satuan');
            });
    }
};
