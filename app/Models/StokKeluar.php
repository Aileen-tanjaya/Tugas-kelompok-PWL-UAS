<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'jumlah',
        'tanggal',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}