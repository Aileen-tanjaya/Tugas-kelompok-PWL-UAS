<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\Product;
use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    public function index()
    {
        // SUDAH DIUBAH: Menggunakan get() agar langsung tampil semua dalam 1 halaman
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
        // Keterangan dihapus, Supplier TETAP ADA
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

        $product = Product::find($request->product_id);
        $product->stok += $request->jumlah;
        $product->save();

        return redirect()->route('stok_masuk.index')
            ->with('success', 'Stok masuk berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(StokMasuk $stokMasuk)
    {
        $products = Product::all();

        return view('stok_masuk.edit', compact('stokMasuk', 'products'));
    }

    public function update(Request $request, StokMasuk $stokMasuk)
    {
        // Keterangan dihapus, Supplier TETAP ADA
        $request->validate([
            'product_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'supplier' => 'required',
        ]);

        $produkLama = Product::find($stokMasuk->product_id);
        $produkLama->stok -= $stokMasuk->jumlah;
        $produkLama->save();

        $produkBaru = Product::find($request->product_id);
        $produkBaru->stok += $request->jumlah;
        $produkBaru->save();

        $stokMasuk->update([
            'product_id' => $request->product_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
        ]);

        return redirect()->route('stok_masuk.index')
            ->with('success', 'Stok masuk berhasil diupdate');
    }

    public function destroy(StokMasuk $stokMasuk)
    {
        $product = Product::find($stokMasuk->product_id);
        $product->stok -= $stokMasuk->jumlah;
        $product->save();

        $stokMasuk->delete();

        return redirect()->route('stok_masuk.index')
            ->with('success', 'Stok masuk berhasil dihapus');
    }
}