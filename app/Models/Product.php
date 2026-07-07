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
    ];

    public function stokMasuks()
    {
        return $this->hasMany(StokMasuk::class, 'product_id');
    }

    /**

     * Hubungan ke transaksi keluar

     */

    public function stokKeluars()
    {
        return $this->hasMany(StokKeluar::class, 'product_id');
    }

    public function getSisaStokReportAttribute()
    {
        $totalMasuk = $this->stokMasuks()->sum('jumlah');
        $totalKeluar = $this->stokKeluars()->sum('jumlah');
        return $totalMasuk - $totalKeluar;
    }
} 

