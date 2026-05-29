<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $filterStatus = $request->query('status', '');
        $filterStok = $request->query('stok', '');
        $perPage = 10;
        $currentPage = max(1, (int) LengthAwarePaginator::resolveCurrentPage());

        $allProducts = Product::orderBy('id')->get();
        $totalProducts = $allProducts->count();
        $totalLowStock = $allProducts
            ->filter(fn ($product) => $this->isActive($product) && $this->isLowStock($product))
            ->count();
        $totalInactive = $allProducts->filter(fn ($product) => ! $this->isActive($product))->count();

        $filteredProducts = $allProducts
            ->when($search !== '', function ($products) use ($search) {
                $keyword = mb_strtolower($search);

                return $products->filter(function ($product) use ($keyword) {
                    return str_contains(mb_strtolower((string) ($product->nama_bunga ?? '')), $keyword)
                        || str_contains(mb_strtolower((string) ($product->satuan ?? '')), $keyword)
                        || str_contains((string) ($product->id ?? ''), $keyword);
                });
            })
            ->when($filterStatus === 'aktif', fn ($products) => $products->filter(fn ($product) => $this->isActive($product)))
            ->when($filterStatus === 'nonaktif', fn ($products) => $products->filter(fn ($product) => ! $this->isActive($product)))
            ->when($filterStok === 'perlu_restock', fn ($products) => $products->filter(fn ($product) => $this->isActive($product) && $this->isLowStock($product)))
            ->when($filterStok === 'habis', fn ($products) => $products->filter(fn ($product) => (int) ($product->stok_saat_ini ?? 0) <= 0))
            ->when($filterStok === 'aman', fn ($products) => $products->filter(fn ($product) => ! $this->isLowStock($product)))
            ->values();

        $products = new LengthAwarePaginator(
            $filteredProducts->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $filteredProducts->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('products.index', compact(
            'products',
            'totalProducts',
            'totalLowStock',
            'totalInactive',
            'search',
            'filterStatus',
            'filterStok'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bunga'    => 'required',
            'satuan'        => 'required',
            'harga_jual'    => 'required|numeric|min:5000',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:1',
        ]);

        if ($this->productNameExists($validated['nama_bunga'])) {
            return back()
                ->withInput()
                ->with('error', 'Nama produk sudah ada. Gunakan nama bunga yang berbeda agar data produk, mobile kasir, dan prediksi tidak membingungkan.');
        }

        $nextId = ((int) (Product::max('id') ?? Product::max('_id') ?? 0)) + 1;

        $validated['_id'] = $nextId;
        $validated['id'] = $nextId;
        $validated['is_active'] = 1;

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('_id', (int) $id)->firstOrFail();

        $validated = $request->validate([
            'nama_bunga'    => 'required',
            'satuan'        => 'required',
            'harga_jual'    => 'required|numeric|min:5000',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:1',
        ]);

        if ($this->productNameExists($validated['nama_bunga'], (int) ($product->id ?? $product->_id ?? $id))) {
            return back()
                ->withInput()
                ->with('error', 'Nama produk sudah dipakai produk lain. Perubahan dibatalkan agar data produk tetap mudah ditelusuri.');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::where('_id', (int) $id)->firstOrFail();
        $product->update(['is_active' => 0]);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga dinonaktifkan');
    }

    public function activate($id)
    {
        $product = Product::where('_id', (int) $id)->firstOrFail();
        $product->update(['is_active' => 1]);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil diaktifkan kembali');
    }

    private function isActive($product): bool
    {
        return (int) ($product->is_active ?? 1) === 1;
    }

    private function isLowStock($product): bool
    {
        return (int) ($product->stok_saat_ini ?? 0) <= (int) ($product->stok_minimum ?? 0);
    }

    private function productNameExists(string $name, ?int $ignoreId = null): bool
    {
        $normalizedName = $this->normalizeProductName($name);

        return Product::all()->contains(function ($product) use ($normalizedName, $ignoreId) {
            $productId = (int) ($product->id ?? $product->_id ?? 0);

            if ($ignoreId !== null && $productId === $ignoreId) {
                return false;
            }

            return $this->normalizeProductName((string) ($product->nama_bunga ?? '')) === $normalizedName;
        });
    }

    private function normalizeProductName(string $name): string
    {
        return mb_strtolower(trim(preg_replace('/\s+/', ' ', $name)));
    }
}
