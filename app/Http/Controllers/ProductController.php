<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Menampilkan daftar barang
    public function index(): View
    {
        $query = Product::query();

        if (request()->has('search') && request()->search != '') {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
            });
        }

        // SINKRONISASI LOGIKA BARU + STOK AMAN
        $totalBarang = Product::count();
        $stokAman    = Product::where('stok', '>', 2)->count();
        $stokMenipis = Product::where('stok', '>', 0)->where('stok', '<=', 2)->count();
        $stokHabis   = Product::where('stok', '<=', 0)->count();

        // PERBAIKAN: Mengubah paginate(10) menjadi get() agar tampil semua dalam 1 halaman
        $products = $query->orderBy('id', 'desc')->get();

        return view('products.index', compact('products', 'totalBarang', 'stokAman', 'stokMenipis', 'stokHabis'));
    }

    // Tambah Barang
    public function create(): View
    {
        return view('products.create');
    }

    // Simpan Barang Baru
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:products,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'required|string|max:50',
            'harga'       => 'required|numeric|min:0',
        ]);

        Product::create([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'harga'       => $validated['harga'],
            'stok'        => 0, 
        ]);

        return Redirect::route('products.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Edit Barang
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    // Update Barang
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:products,kode_barang,' . $product->id,
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'required|string|max:50',
            'harga'       => 'required|numeric|min:0',
        ]);

        $product->update([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'harga'       => $validated['harga'],
            'stok'        => $product->stok, 
        ]);

        return Redirect::route('products.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return Redirect::route('products.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function stok(): View
    {
        $query = Product::query();

        if (request()->has('search') && request()->search != '') {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
            });
        }

        // SINKRONISASI LOGIKA BARU + STOK AMAN
        $totalBarang = Product::count();
        $stokAman    = Product::where('stok', '>', 2)->count();
        $stokMenipis = Product::where('stok', '>', 0)->where('stok', '<=', 2)->count();
        $stokHabis   = Product::where('stok', '<=', 0)->count();

        // PERBAIKAN: Mengubah paginate(10) menjadi get() agar halaman Manajemen Stok tampil utuh
        $products = $query->orderBy('id', 'desc')->get();

        return view('stok.index', compact('products', 'totalBarang', 'stokAman', 'stokMenipis', 'stokHabis'));
    }
}