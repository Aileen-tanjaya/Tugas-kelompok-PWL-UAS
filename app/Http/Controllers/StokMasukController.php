<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokMasukController extends Controller
{
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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('stok_masuk.index')->with('success', 'Stok masuk berhasil ditambahkan');
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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('stok_masuk.index')->with('success', 'Stok masuk berhasil diupdate');
    }
}