<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StokKeluarController extends Controller
{
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
            'user_id'    => Auth::id(),
        ]);

        return redirect()->route('stok_keluar.index')->with('success', 'Stok keluar berhasil dicatat.');
    }
}