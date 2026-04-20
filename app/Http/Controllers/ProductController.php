<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_bunga'   => 'required|unique:products',
            'satuan'       => 'required',
            'stok_minimum' => 'required|integer|min:1',
        ]);
        Product::create($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil ditambahkan');
    }

    public function update(Request $request, Product $product) {
        $product->update($request->all());
        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil diperbarui');
    }

    public function destroy(Product $product) {
        $product->update(['is_active' => false]);
        return redirect()->route('products.index')
            ->with('success', 'Produk bunga dinonaktifkan');
    }
}