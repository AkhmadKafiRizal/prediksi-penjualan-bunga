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
            'nama_bunga'   => 'required|unique:products,nama_bunga',
            'satuan'       => 'required',
            'stok_minimum' => 'required|integer|min:1',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil ditambahkan');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_bunga'   => 'required|unique:products,nama_bunga,' . $product->id,
            'satuan'       => 'required',
            'harga_jual'   => 'nullable|numeric|min:0',
            'stok_minimum' => 'required|integer|min:1',
            'is_active'    => 'nullable|boolean',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->update(['is_active' => false]);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga dinonaktifkan');
    }
}