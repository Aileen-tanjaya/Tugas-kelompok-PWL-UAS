<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function tampilkanStok(Request $request)
    {
        $query = Product::query()->orderBy('id', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where('kode_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $request->search . '%');
        }

        $allProducts = $query->get();

        foreach ($allProducts as $product) {
            $product->calculated_stok = $product->sisa_stok_report;
        }

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

        $products = $allProducts;

        return view('stok.index', compact('products', 'totalBarang', 'stokAman', 'stokMenipis', 'stokHabis'));
    }
}