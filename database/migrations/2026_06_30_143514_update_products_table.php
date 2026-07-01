<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products','kode_barang')) {
                $table->string('kode_barang')->unique()->after('id');
            }

            if (!Schema::hasColumn('products','satuan')) {
                $table->string('satuan')->after('nama_barang');
            }

        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (Schema::hasColumn('products','kode_barang')) {
                $table->dropColumn('kode_barang');
            }

            if (Schema::hasColumn('products','satuan')) {
                $table->dropColumn('satuan');
            }

        });
    }
};