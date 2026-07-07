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

        // Tampil semua urut berdasarkan id terbaru
        $products = $query->orderBy('id', 'desc')->get();

        // SINKRONISASI LOGIKA REAL-TIME: Pasang hasil hitungan (Masuk - Keluar) ke masing-masing produk
        foreach ($products as $product) {
            $product->calculated_stok = $product->sisa_stok_report;
        }

        // HITUNG STATISTIK KOTAK SECARA LIVE REPORT (Aman, Menipis, Habis)
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

        // Simpan data produk ke tabel products
        Product::create([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'harga'       => $validated['harga'],
        ]);

        // Catatan: Pembuatan stok default '0' dihapus karena stok sekarang dihitung live dari riwayat transaksi masuk & keluar.

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
        ]);

        return Redirect::route('products.index')->with('success', 'Barang berhasil diperbarui.');
    }

    // Hapus Barang
    public function destroy(Product $product): RedirectResponse
    {
        // Menghapus data riwayat transaksi terkait agar tidak error foreign key
        $product->stokMasuks()->delete();
        $product->stokKeluars()->delete();
        $product->delete();
        return Redirect::route('products.index')->with('success', 'Barang berhasil dihapus.');
    }

} 

