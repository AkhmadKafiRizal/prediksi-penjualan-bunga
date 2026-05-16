<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET /api/stocks
    |--------------------------------------------------------------------------
    | Dipakai Flutter untuk mengambil daftar produk dan stok dari MongoDB Atlas.
    | Data dibaca dari collection products.
    */
    public function index(Request $request)
    {
        $query = DB::connection('mongodb')->table('products');

        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('nama_bunga', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $products = $query
            ->orderBy('id')
            ->get()
            ->map(function ($product) {
                $productId = (int) ($product->id ?? $product->_id ?? 0);

                $namaBunga = $product->nama_bunga
                    ?? $product->name
                    ?? $product->nama
                    ?? 'Produk';

                $satuan = $product->satuan ?? 'tangkai';

                $hargaJual = (float) (
                    $product->harga_jual
                    ?? $product->price
                    ?? 0
                );

                $stokSaatIni = (int) (
                    $product->stok_saat_ini
                    ?? $product->stock
                    ?? 0
                );

                $stokMinimum = (int) (
                    $product->stok_minimum
                    ?? $product->minimum_stock
                    ?? $product->min_stock
                    ?? 0
                );

                $category = $product->category
                    ?? $product->kategori
                    ?? 'Bunga Potong';

                $costPrice = (float) (
                    $product->cost_price
                    ?? $product->harga_modal
                    ?? 0
                );

                $imageUrl = $product->image_url
                    ?? $product->gambar
                    ?? null;

                $updatedAt = $product->updated_at
                    ?? now();

                $isLowStock = $stokSaatIni <= $stokMinimum;

                return [
                    // ID utama
                    'id'              => $productId,
                    'product_id'      => $productId,

                    // Nama
                    'nama_bunga'      => $namaBunga,
                    'name'            => $namaBunga,

                    // Kategori
                    'category'        => $category,
                    'kategori'        => $category,

                    // Satuan
                    'satuan'          => $satuan,
                    'unit'            => $satuan,

                    // Harga
                    'harga_jual'      => $hargaJual,
                    'price'           => $hargaJual,
                    'cost_price'      => $costPrice,

                    // Stok
                    'stok_saat_ini'   => $stokSaatIni,
                    'stock'           => $stokSaatIni,
                    'stok_minimum'    => $stokMinimum,
                    'minimum_stock'   => $stokMinimum,
                    'min_stock'       => $stokMinimum,

                    // Status stok
                    'low_stock'       => $isLowStock,
                    'is_low_stock'    => $isLowStock,

                    // Tambahan untuk Flutter model
                    'image_url'       => $imageUrl,
                    'updated_at'      => (string) $updatedAt,

                    // Status produk
                    'is_active'       => (int) ($product->is_active ?? 1),
                ];
            })
            ->values();

        if ($request->boolean('low_stock')) {
            $products = $products
                ->filter(function ($product) {
                    return $product['low_stock'] === true;
                })
                ->values();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data stok berhasil diambil.',
            'data'    => $products,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | POST /api/stocks
    |--------------------------------------------------------------------------
    | Dipakai Flutter untuk menambah produk baru.
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bunga'     => 'nullable|string|max:255',
            'name'           => 'nullable|string|max:255',
            'satuan'         => 'nullable|string|max:50',
            'unit'           => 'nullable|string|max:50',
            'category'       => 'nullable|string|max:100',
            'kategori'       => 'nullable|string|max:100',
            'harga_jual'     => 'nullable|numeric|min:0',
            'price'          => 'nullable|numeric|min:0',
            'cost_price'     => 'nullable|numeric|min:0',
            'harga_modal'    => 'nullable|numeric|min:0',
            'stok_saat_ini'  => 'nullable|integer|min:0',
            'stock'          => 'nullable|integer|min:0',
            'stok_minimum'   => 'nullable|integer|min:0',
            'minimum_stock'  => 'nullable|integer|min:0',
            'min_stock'      => 'nullable|integer|min:0',
            'image_url'      => 'nullable|string|max:500',
        ]);

        $namaBunga = $validated['nama_bunga']
            ?? $validated['name']
            ?? null;

        if (!$namaBunga) {
            return response()->json([
                'success' => false,
                'message' => 'Nama bunga wajib diisi.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil ID produk terakhir dengan aman untuk MongoDB
        |--------------------------------------------------------------------------
        | Jangan pakai max('id') karena pada mongodb/laravel-mongodb field id
        | kadang bisa terbaca sebagai alias _id.
        */
        $lastId = DB::connection('mongodb')
            ->table('products')
            ->get()
            ->map(function ($product) {
                return (int) ($product->id ?? $product->_id ?? 0);
            })
            ->max();

        $newId = ((int) $lastId) + 1;

        $satuan = $validated['satuan']
            ?? $validated['unit']
            ?? 'tangkai';

        $category = $validated['category']
            ?? $validated['kategori']
            ?? 'Bunga Potong';

        $hargaJual = $validated['harga_jual']
            ?? $validated['price']
            ?? 0;

        $costPrice = $validated['cost_price']
            ?? $validated['harga_modal']
            ?? 0;

        $stokSaatIni = $validated['stok_saat_ini']
            ?? $validated['stock']
            ?? 0;

        $stokMinimum = $validated['stok_minimum']
            ?? $validated['minimum_stock']
            ?? $validated['min_stock']
            ?? 1;

        $imageUrl = $validated['image_url'] ?? null;

        $product = [
            '_id'             => $newId,
            'id'              => $newId,
            'nama_bunga'      => $namaBunga,
            'category'        => $category,
            'satuan'          => $satuan,
            'harga_jual'      => (float) $hargaJual,
            'cost_price'      => (float) $costPrice,
            'stok_saat_ini'   => (int) $stokSaatIni,
            'stok_minimum'    => (int) $stokMinimum,
            'image_url'       => $imageUrl,
            'is_active'       => 1,
            'created_at'      => now(),
            'updated_at'      => now(),
        ];

        DB::connection('mongodb')
            ->table('products')
            ->insert($product);

        return response()->json([
            'success' => true,
            'message' => 'Produk baru berhasil ditambahkan.',
            'data'    => [
                'id'              => $newId,
                'product_id'      => $newId,
                'nama_bunga'      => $namaBunga,
                'name'            => $namaBunga,
                'category'        => $category,
                'kategori'        => $category,
                'satuan'          => $satuan,
                'unit'            => $satuan,
                'harga_jual'      => (float) $hargaJual,
                'price'           => (float) $hargaJual,
                'cost_price'      => (float) $costPrice,
                'stok_saat_ini'   => (int) $stokSaatIni,
                'stock'           => (int) $stokSaatIni,
                'stok_minimum'    => (int) $stokMinimum,
                'minimum_stock'   => (int) $stokMinimum,
                'min_stock'       => (int) $stokMinimum,
                'low_stock'       => (int) $stokSaatIni <= (int) $stokMinimum,
                'is_low_stock'    => (int) $stokSaatIni <= (int) $stokMinimum,
                'image_url'       => $imageUrl,
                'updated_at'      => (string) now(),
                'is_active'       => 1,
            ],
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | PATCH /api/stocks/{id}/adjust
    |--------------------------------------------------------------------------
    | Dipakai Flutter untuk menambah/mengurangi stok produk.
    |
    | type yang didukung:
    | - add, in, masuk, increase, tambah
    | - subtract, out, keluar, decrease, kurang
    */
    public function adjust(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'type'     => 'required|string',
        ]);

        $product = DB::connection('mongodb')
            ->table('products')
            ->where('id', (int) $id)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $currentStock = (int) ($product->stok_saat_ini ?? 0);
        $quantity = (int) $validated['quantity'];
        $type = strtolower($validated['type']);

        $increaseTypes = ['add', 'in', 'masuk', 'increase', 'tambah'];
        $decreaseTypes = ['subtract', 'out', 'keluar', 'decrease', 'kurang'];

        if (in_array($type, $increaseTypes, true)) {
            $newStock = $currentStock + $quantity;
        } elseif (in_array($type, $decreaseTypes, true)) {
            $newStock = max(0, $currentStock - $quantity);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tipe perubahan stok tidak valid.',
            ], 422);
        }

        DB::connection('mongodb')
            ->table('products')
            ->where('id', (int) $id)
            ->update([
                'stok_saat_ini' => $newStock,
                'updated_at'    => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Stok produk berhasil diperbarui.',
            'data'    => [
                'id'             => (int) $id,
                'stok_saat_ini'  => $newStock,
                'stock'          => $newStock,
            ],
        ]);
    }
}