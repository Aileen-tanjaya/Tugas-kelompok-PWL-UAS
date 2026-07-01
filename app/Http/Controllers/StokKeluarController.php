<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StokKeluar; // Pastikan nama model sesuai dengan aplikasi Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index()
    {
        // Mengambil data stok keluar beserta relasi produknya
        $stokKeluars = StokKeluar::with('product')->latest()->paginate(10);
        return view('stok_keluar.index', compact('stokKeluars'));
    }

    public function create()
    {
        // Ambil semua produk untuk pilihan di form dropdown
        $products = Product::all();
        return view('stok_keluar.create', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
            'tujuan'     => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // 2. Gunakan Database Transaction agar aman dan sinkron
        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            // Validasi apakah stok cukup sebelum dikurangi
            if ($product->stok < $request->jumlah) {
                throw new \Exception("Stok tidak mencukupi! Stok tersedia saat ini: {$product->stok}");
            }

            // Simpan data transaksi stok keluar
            StokKeluar::create([
                'product_id' => $request->product_id,
                'jumlah'     => $request->jumlah,
                'tanggal'    => $request->tanggal,
                'tujuan'     => $request->tujuan,
                'keterangan' => $request->keterangan,
            ]);

            // PAKSA Kurangi stok di tabel produk secara otomatis
            $product->decrement('stok', $request->jumlah);
        });

        // 3. PAKSA REDIRECT KEMBALI KE HALAMAN UTAMA (INDEX)
        return redirect()->route('stok_keluar.index')->with('success', 'Transaksi stok keluar berhasil dicatat dan stok barang otomatis berkurang!');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stokKeluar = StokKeluar::findOrFail($id);
            $product = Product::findOrFail($stokKeluar->product_id);

            // Kembalikan stok yang sempat dikurangi sebelum log dihapus
            $product->increment('stok', $stokKeluar->jumlah);
            
            $stokKeluar->delete();
        });

        return redirect()->route('stok_keluar.index')->with('success', 'Log transaksi berhasil dihapus dan stok barang telah dikembalikan!');
    }
}