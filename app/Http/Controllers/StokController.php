<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class StokController extends Controller
{
    public function index(): View
    {
        // 1. Mulai Query Dasar Model Product
        $query = Product::query();

        // 2. Filter Status
        if (request()->filled('status')) {
            $status = request('status');
            
            if ($status === 'aman') {
                $query->where('stok', '>', 2);
            } elseif ($status === 'menipis') {
                $query->where('stok', '>', 0)->where('stok', '<=', 2);
            } elseif ($status === 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        // 3. Filter Pencarian Nama atau Kode Barang
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
            });
        }

        // 4. Hitung Statistik Kotak Atas (Tetap Akurat)
        $totalBarang = Product::count();
        $stokAman    = Product::where('stok', '>', 2)->count();
        $stokMenipis = Product::where('stok', '>', 0)->where('stok', '<=', 2)->count();
        $stokHabis   = Product::where('stok', '<=', 0)->count();

        // 5. PERBAIKAN: Mengubah paginate(10) menjadi get() agar tampil semua data dalam 1 halaman
        $products = $query->orderBy('id', 'desc')->get();

        return view('stok.index', compact('products', 'totalBarang', 'stokAman', 'stokMenipis', 'stokHabis'));
    }

    public function create() { return redirect()->route('stok.index'); }
    public function store() { return redirect()->route('stok.index'); }
    public function edit($id) { return redirect()->route('stok.index'); }
    public function update($id) { return redirect()->route('stok.index'); }
    public function destroy($id) { return redirect()->route('stok.index'); }
}