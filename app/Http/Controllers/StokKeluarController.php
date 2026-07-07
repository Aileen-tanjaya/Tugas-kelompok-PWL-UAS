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
        $stokKeluars = StokKeluar::with('product')->latest()->get();
        return view('stok_keluar.index', compact('stokKeluars'));
    }

    public function create()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $totalMasuk = StokMasuk::where('product_id', $product->id)->sum('jumlah');
            $totalKeluar = StokKeluar::where('product_id', $product->id)->sum('jumlah');

            $product->sisa_stok_report = $totalMasuk - $totalKeluar;
        }

        return view('stok_keluar.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
        ]);

        $totalMasuk = StokMasuk::where('product_id', $request->product_id)->sum('jumlah');
        $totalKeluar = StokKeluar::where('product_id', $request->product_id)->sum('jumlah');
        $sisaStokRealTime = $totalMasuk - $totalKeluar;

        if ($sisaStokRealTime < $request->jumlah) {
            return back()->withErrors(['jumlah' => "Stok tidak mencukupi! Sisa stok saat ini hanya: {$sisaStokRealTime}"])->withInput();
        }

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