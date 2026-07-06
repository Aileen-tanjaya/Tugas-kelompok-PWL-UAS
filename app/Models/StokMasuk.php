<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $table = 'stok_masuks';

    protected $fillable = [
        'product_id',
        'jumlah',
        'tanggal',
        'supplier',
        'user_id', 
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}