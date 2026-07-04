<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StokController extends Controller
{

    public function index(): View
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);

        return view('stok.index', compact('products'));
    }

    public function create()
    {
        return redirect()->route('stok.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('stok.index');
    }

    public function edit($id)
    {
        return redirect()->route('stok.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('stok.index');
    }

    public function destroy($id)
    {
        return redirect()->route('stok.index');
    }
}