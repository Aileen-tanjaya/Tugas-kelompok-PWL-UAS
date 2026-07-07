<?php

namespace App\Http\Controllers;
use App\Models\StokMasuk;
use App\Models\Product;
use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    public function index()
    {
        $stokMasuks = StokMasuk::latest()->get();
        return view('stok_masuk.index', compact('stokMasuks'));

    }

    public function create()
    {
        $products = Product::all();
        return view('stok_masuk.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'supplier' => 'required',
        ]);

        StokMasuk::create([
            'product_id' => $request->product_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
        ]);

        return redirect()->route('stok_masuk.index')->with('success', 'Stok masuk berhasil ditambahkan');
    }

    public function edit(StokMasuk $stokMasuk)
    {
        $products = Product::all();
        return view('stok_masuk.edit', compact('stokMasuk', 'products'));
    }

    public function update(Request $request, StokMasuk $stokMasuk)
    {
        $request->validate([
            'product_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'supplier' => 'required',
        ]);

        $stokMasuk->update([
            'product_id' => $request->product_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
        ]);

        return redirect()->route('stok_masuk.index')->with('success', 'Stok masuk berhasil diupdate');
    }

    public function destroy(StokMasuk $stokMasuk)
    {
        $stokMasuk->delete();
        return redirect()->route('stok_masuk.index')->with('success', 'Stok masuk berhasil dihapus');
    }
} 