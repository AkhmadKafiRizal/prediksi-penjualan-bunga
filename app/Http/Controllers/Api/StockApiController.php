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
    | Dipakai mobile untuk mengambil daftar produk dan stok dari MongoDB Atlas.
    | Data dibaca dari collection products.
    */
    public function index(Request $request)
    {
        $query = DB::connection('mongodb')
            ->table('products');

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
                $stokSaatIni = (int) ($product->stok_saat_ini ?? 0);
                $stokMinimum = (int) ($product->stok_minimum ?? 0);

                return [
                    'id'              => (int) ($product->id ?? $product->_id ?? 0),
                    'product_id'      => (int) ($product->id ?? $product->_id ?? 0),
                    'nama_bunga'      => $product->nama_bunga ?? $product->name ?? $product->nama ?? 'Produk',
                    'name'            => $product->nama_bunga ?? $product->name ?? $product->nama ?? 'Produk',
                    'satuan'          => $product->satuan ?? 'tangkai',
                    'harga_jual'      => (float) ($product->harga_jual ?? 0),
                    'price'           => (float) ($product->harga_jual ?? 0),
                    'stok_saat_ini'   => $stokSaatIni,
                    'stock'           => $stokSaatIni,
                    'stok_minimum'    => $stokMinimum,
                    'minimum_stock'   => $stokMinimum,
                    'low_stock'       => $stokSaatIni <= $stokMinimum,
                    'is_active'       => (int) ($product->is_active ?? 1),
                ];
            });

        if ($request->boolean('low_stock')) {
            $products = $products->filter(function ($product) {
                return $product['low_stock'] === true;
            })->values();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data stok berhasil diambil.',
            'data'    => $products->values(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PATCH /api/stocks/{id}/adjust
    |--------------------------------------------------------------------------
    | Dipakai mobile untuk menambah/mengurangi stok produk.
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
            $product = DB::connection('mongodb')
                ->table('products')
                ->where('_id', (int) $id)
                ->first();
        }

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        $currentStock = (int) ($product->stok_saat_ini ?? 0);
        $quantity     = (int) $validated['quantity'];
        $type         = strtolower($validated['type']);

        if (in_array($type, ['add', 'in', 'masuk', 'increase', 'tambah'], true)) {
            $newStock = $currentStock + $quantity;
        } elseif (in_array($type, ['subtract', 'out', 'keluar', 'decrease', 'kurang'], true)) {
            $newStock = max(0, $currentStock - $quantity);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tipe penyesuaian stok tidak valid.',
            ], 422);
        }

        DB::connection('mongodb')
            ->table('products')
            ->where('_id', $product->_id ?? (int) $id)
            ->update([
                'stok_saat_ini' => $newStock,
                'updated_at'    => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Stok produk berhasil diperbarui.',
            'data'    => [
                'id'              => (int) ($product->id ?? $product->_id ?? $id),
                'product_id'      => (int) ($product->id ?? $product->_id ?? $id),
                'stok_saat_ini'   => $newStock,
                'stock'           => $newStock,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | POST /api/stocks
    |--------------------------------------------------------------------------
    | Dipakai mobile jika ada fitur tambah produk dari mobile.
    | Data disimpan ke collection products.
    |
    | Catatan:
    | Collection products memakai _id numerik untuk produk lama.
    | Karena itu produk baru juga dibuat dengan _id numerik berikutnya.
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bunga'     => 'nullable|string|max:255',
            'name'           => 'nullable|string|max:255',
            'satuan'         => 'nullable|string|max:50',
            'harga_jual'     => 'nullable|numeric|min:0',
            'price'          => 'nullable|numeric|min:0',
            'stok_saat_ini'  => 'nullable|integer|min:0',
            'stock'          => 'nullable|integer|min:0',
            'stok_minimum'   => 'nullable|integer|min:0',
            'minimum_stock'  => 'nullable|integer|min:0',
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
        | Ambil ID produk terakhir dengan cara aman untuk MongoDB
        |--------------------------------------------------------------------------
        | Jangan pakai max('id') karena pada mongodb/laravel-mongodb field id
        | bisa menjadi alias dari _id dan hasilnya bisa tidak sesuai.
        */
        $lastId = DB::connection('mongodb')
            ->table('products')
            ->get()
            ->map(function ($product) {
                return (int) ($product->id ?? $product->_id ?? 0);
            })
            ->max();

        $newId = ((int) $lastId) + 1;

        $hargaJual = $validated['harga_jual']
            ?? $validated['price']
            ?? 0;

        $stokSaatIni = $validated['stok_saat_ini']
            ?? $validated['stock']
            ?? 0;

        $stokMinimum = $validated['stok_minimum']
            ?? $validated['minimum_stock']
            ?? 1;

        $product = [
            '_id'             => $newId,
            'nama_bunga'      => $namaBunga,
            'satuan'          => $validated['satuan'] ?? 'tangkai',
            'harga_jual'      => (float) $hargaJual,
            'stok_saat_ini'   => (int) $stokSaatIni,
            'stok_minimum'    => (int) $stokMinimum,
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
                'satuan'          => $product['satuan'],
                'harga_jual'      => $product['harga_jual'],
                'price'           => $product['harga_jual'],
                'stok_saat_ini'   => $product['stok_saat_ini'],
                'stock'           => $product['stok_saat_ini'],
                'stok_minimum'    => $product['stok_minimum'],
                'minimum_stock'   => $product['stok_minimum'],
                'is_active'       => $product['is_active'],
            ],
        ], 201);
    }
}