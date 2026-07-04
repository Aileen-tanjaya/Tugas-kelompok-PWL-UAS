<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StokController extends Controller
{
    public function index(): View
    {
        $query = Product::query();

        // Fitur Pencarian
        if (request()->has('search') && request()->search != '') {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
            });
        }

        // Perhitungan Badge Statistik Baru + STOK AMAN
        $totalBarang = Product::count();
        $stokAman    = Product::where('stok', '>', 2)->count();
        $stokMenipis = Product::where('stok', '>', 0)->where('stok', '<=', 2)->count();
        $stokHabis   = Product::where('stok', '<=', 0)->count();

        $products = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('stok.index', compact('products', 'totalBarang', 'stokAman', 'stokMenipis', 'stokHabis'));
    }

    public function create() { return redirect()->route('stok.index'); }
    public function store(Request $request) { return redirect()->route('stok.index'); }
    public function edit($id) { return redirect()->route('stok.index'); }
    public function update(Request $request, $id) { return redirect()->route('stok.index'); }
    public function destroy($id) { return redirect()->route('stok.index'); }
}