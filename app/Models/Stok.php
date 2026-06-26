<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';

    protected $fillable = [
        'user_id',
        'kode_barang',
        'nama_barang',
        'stok_masuk',
        'stok_keluar',
        'stok',
        'tanggal_update', 
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}