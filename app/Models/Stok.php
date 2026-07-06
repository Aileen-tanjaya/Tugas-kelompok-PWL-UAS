<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stok extends Model
{
    use HasFactory;

    // FIX UTAMA: Diubah kembali ke 'stoks' sesuai dengan tabel yang ada di databasemu
    protected $table = 'stoks';

    // Menyesuaikan fillable dengan ERD & Relasi Tabel terbaru
    protected $fillable = [
        'user_id',
        'product_id',
        'stok',
        'status',
    ];

    /**
     * Hubungan ke tabel Users (Admin yang mencatat)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Menambahkan relasi balik ke tabel Product (Barang)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}