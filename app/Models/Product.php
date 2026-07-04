<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'harga',
        'stok'
    ];

    public function stokMasuks()
    {
        return $this->hasMany(StokMasuk::class);
    }

    public function stokKeluars()
    {
        return $this->hasMany(StokKeluar::class);
    }
}