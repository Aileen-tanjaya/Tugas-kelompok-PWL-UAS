<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Mengubah nama fungsi agar tidak bentrok dengan Controller induk bawaan
    public function tampilkanStok(Request $request)
    {
        // 1. Ambil semua produk - DITAMBAHKAN URUTAN TERBARU DI ATAS (orderBy)
        $query = Product::query()->orderBy('id', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $request->search . '%');
        }

        $allProducts = $query->get();

        // 2. Pasangkan hitungan report real-time ke setiap produk
        foreach ($allProducts as $product) {
            $product->calculated_stok = $product->sisa_stok_report;
        }

        // 3. Filter berdasarkan Status Dropdown (jika dipilih)
        if ($request->has('status') && $request->status != '') {
            $allProducts = $allProducts->filter(function ($product) use ($request) {
                if ($request->status == 'habis') {
                    return $product->calculated_stok <= 0;
                } elseif ($request->status == 'menipis') {
                    return $product->calculated_stok > 0 && $product->calculated_stok <= 2;
                } elseif ($request->status == 'aman') {
                    return $product->calculated_stok > 2;
                }
                return true;
            });
        }

        // 4. HITUNG STATISTIK KOTAK (Aman, Menipis, Habis) secara live report
        $productsForBadges = Product::all();
        $totalBarang = $productsForBadges->count();
        $stokAman = 0;
        $stokMenipis = 0;
        $stokHabis = 0;

        foreach ($productsForBadges as $p) {
            $current = $p->sisa_stok_report;
            if ($current <= 0) {
                $stokHabis++;
            } elseif ($current > 0 && $current <= 2) {
                $stokMenipis++;
            } else {
                $stokAman++;
            }
        }

        // Kirim data ke view index manajemen stok
        $products = $allProducts;

        return view('stok.index', compact('products', 'totalBarang', 'stokAman', 'stokMenipis', 'stokHabis'));
    }
}