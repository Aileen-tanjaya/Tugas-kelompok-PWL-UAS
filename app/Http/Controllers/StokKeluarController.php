<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index()
    {
        // Tampilkan semua data stok keluar
        $stokKeluars = StokKeluar::with('product')->latest()->get();
        return view('stok_keluar.index', compact('stokKeluars'));
    }

    public function create()
    {
        $products = Product::all();

        // FIX TOTAL: Hitung otomatis sisa stok berdasarkan laporan real-time untuk dropdown
        foreach ($products as $product) {
            $totalMasuk = StokMasuk::where('product_id', $product->id)->sum('jumlah');
            $totalKeluar = StokKeluar::where('product_id', $product->id)->sum('jumlah');
            
            // Masukkan hasil kalkulasi ke properti sisa_stok_report yang dipanggil oleh file blade
            $product->sisa_stok_report = $totalMasuk - $totalKeluar;
        }

        return view('stok_keluar.create', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
        ]);

        // 2. Hitung sisa stok real-time untuk validasi input sebelum disimpan
        $totalMasuk = StokMasuk::where('product_id', $request->product_id)->sum('jumlah');
        $totalKeluar = StokKeluar::where('product_id', $request->product_id)->sum('jumlah');
        $sisaStokRealTime = $totalMasuk - $totalKeluar;
        
        // Cek jika jumlah yang dikeluarkan melebihi stok yang ada di report masuk
        if ($sisaStokRealTime < $request->jumlah) {
            return back()->withErrors(['jumlah' => "Stok tidak mencukupi! Sisa stok saat ini hanya: {$sisaStokRealTime}"])->withInput();
        }

        // 3. Simpan data transaksi stok keluar
        StokKeluar::create([
            'product_id' => $request->product_id,
            'jumlah'     => $request->jumlah,
            'tanggal'    => $request->tanggal,
        ]);

        return redirect()->route('stok_keluar.index')->with('success', 'Stok keluar berhasil dicatat.');
    }

    public function destroy($id)
    {
        $stokKeluar = StokKeluar::findOrFail($id);
        $stokKeluar->delete();

        return redirect()->route('stok_keluar.index')->with('success', 'Catatan stok keluar berhasil dihapus.');
    }
}