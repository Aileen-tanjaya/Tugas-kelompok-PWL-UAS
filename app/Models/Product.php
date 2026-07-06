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
        'stok',
        'satuan',
        'harga',
        'user_id',
        'updated_by'
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function stokMasuks()
    {
        return $this->hasMany(StokMasuk::class, 'product_id');
    }

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