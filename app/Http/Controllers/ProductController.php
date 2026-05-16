<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id')->paginate(10);
        $totalProducts = Product::count();

        return view('products.index', compact('products', 'totalProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bunga'    => 'required',
            'satuan'        => 'required',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:1',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil ditambahkan');
    }

    public function update(Request $request, $id)
{
    $product = Product::where('_id', (int)$id)->firstOrFail();

    $request->validate([
        'nama_bunga'    => 'required',
        'satuan'        => 'required',
        'harga_jual'    => 'nullable|numeric|min:0',
        'stok_saat_ini' => 'required|integer|min:0',
        'stok_minimum'  => 'required|integer|min:1',
        'is_active'     => 'nullable',
    ]);

    $product->update($request->only([
        'nama_bunga',
        'satuan',
        'harga_jual',
        'stok_saat_ini',
        'stok_minimum',
        'is_active',
    ]));

    return redirect()->route('products.index')
        ->with('success', 'Produk bunga berhasil diperbarui');
}

public function destroy($id)
{
    $product = Product::where('_id', (int)$id)->firstOrFail();
    $product->update(['is_active' => false]);

    return redirect()->route('products.index')
        ->with('success', 'Produk bunga dinonaktifkan');
}
}