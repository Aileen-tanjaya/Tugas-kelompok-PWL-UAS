<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('products.index', ['products' => $products]);
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string', 'max:50'],
            'harga'       => ['required', 'numeric'],
        ]);

        Product::create([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'stok'        => $request->input('stok', 0),
            'harga'       => $validated['harga'],
        ]);

        return Redirect::route('products.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string', 'max:50'],
            'harga'       => ['required', 'numeric'],
        ]);

        $product->update([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'stok'        => $request->input('stok', $product->stok),
            'harga'       => $validated['harga'],
        ]);

        return Redirect::route('products.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return Redirect::route('products.index')->with('success', 'Barang berhasil dihapus.');
    }
}