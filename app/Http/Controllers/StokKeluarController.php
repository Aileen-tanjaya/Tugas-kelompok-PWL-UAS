<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index()
    {
        // SUDAH DIUBAH: Menggunakan get() agar langsung tampil semua data dalam 1 halaman
        $stokKeluars = StokKeluar::with('product')->latest()->get();
        return view('stok_keluar.index', compact('stokKeluars'));
    }

    public function create()
    {
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
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => "Stok tidak mencukupi! Sisa stok saat ini hanya: {$product->stok}"])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            StokKeluar::create([
                'product_id' => $request->product_id,
                'jumlah'     => $request->jumlah,
                'tanggal'    => $request->tanggal,
            ]);

            $product->decrement('stok', $request->jumlah);
        });

        return redirect()->route('stok_keluar.index');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stokKeluar = StokKeluar::findOrFail($id);
            $product = Product::findOrFail($stokKeluar->product_id);

            $product->increment('stok', $stokKeluar->jumlah);
            
            $stokKeluar->delete();
        });

        return redirect()->route('stok_keluar.index');
    }
}