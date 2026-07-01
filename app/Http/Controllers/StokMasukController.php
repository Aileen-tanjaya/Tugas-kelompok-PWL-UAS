<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\Product;
use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    public function index()
    {
        $stokMasuks = StokMasuk::latest()->paginate(10);

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
            'keterangan' => 'nullable'
        ]);

        // Simpan ke tabel stok_masuks
        StokMasuk::create([
            'product_id' => $request->product_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
        ]);

        // Tambahkan stok barang
        $product = Product::find($request->product_id);
        $product->stok += $request->jumlah;
        $product->save();

        // PERBAIKAN: Mengubah 'stok-masuk.index' menjadi 'stok_masuk.index'
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
        $request->validate([
            'product_id' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'supplier' => 'required',
            'keterangan' => 'nullable'
        ]);

        // Kembalikan stok lama
        $produkLama = Product::find($stokMasuk->product_id);
        $produkLama->stok -= $stokMasuk->jumlah;
        $produkLama->save();

        // Tambahkan stok baru
        $produkBaru = Product::find($request->product_id);
        $produkBaru->stok += $request->jumlah;
        $produkBaru->save();

        // Update data
        $stokMasuk->update([
            'product_id' => $request->product_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
        ]);

        // PERBAIKAN: Mengubah 'stok-masuk.index' menjadi 'stok_masuk.index'
        return redirect()->route('stok_masuk.index')
            ->with('success', 'Stok masuk berhasil diupdate');
    }

    public function destroy(StokMasuk $stokMasuk)
    {
        // Kurangi stok barang
        $product = Product::find($stokMasuk->product_id);
        $product->stok -= $stokMasuk->jumlah;
        $product->save();

        $stokMasuk->delete();

        // PERBAIKAN: Mengubah 'stok-masuk.index' menjadi 'stok_masuk.index'
        return redirect()->route('stok_masuk.index')
            ->with('success', 'Stok masuk berhasil dihapus');
    }
}