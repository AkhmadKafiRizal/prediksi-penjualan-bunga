<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET /api/transactions
    |--------------------------------------------------------------------------
    | Dipakai mobile untuk mengambil riwayat transaksi penjualan.
    | Data dibaca dari MongoDB Atlas collection penjualans.
    */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 20);
        $page    = (int) $request->query('page', 1);

        $perPage = max(1, min($perPage, 100));
        $page    = max(1, $page);

        $query = DB::connection('mongodb')
            ->table('penjualans');

        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->query('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->query('end_date'));
        }

        $total = (clone $query)->count();

        $rows = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $products = DB::connection('mongodb')
            ->table('products')
            ->get()
            ->keyBy('id');

        $data = $rows->map(function ($row) use ($products) {
            $productId = (int) ($row->product_id ?? 0);
            $product   = $products->get($productId);

            return [
                'id'           => (int) ($row->id ?? 0),
                'product_id'   => $productId,
                'nama_bunga'   => $product->nama_bunga ?? 'Produk #' . $productId,
                'product_name' => $product->nama_bunga ?? 'Produk #' . $productId,
                'tanggal'      => $row->tanggal ?? null,
                'date'         => $row->tanggal ?? null,
                'jumlah'       => (int) ($row->jumlah ?? 0),
                'quantity'     => (int) ($row->jumlah ?? 0),
                'harga'        => (float) ($row->harga ?? 0),
                'price'        => (float) ($row->harga ?? 0),
                'promo'        => (int) ($row->promo ?? 0),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil diambil.',
            'data'    => $data,
            'meta'    => [
                'page'      => $page,
                'per_page'  => $perPage,
                'total'     => $total,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | POST /api/transactions
    |--------------------------------------------------------------------------
    | Dipakai mobile kasir untuk input transaksi penjualan.
    | Data disimpan ke MongoDB Atlas collection penjualans.
    |
    | Field mobile yang didukung:
    | - product_id / flower_id
    | - jumlah / quantity
    | - tanggal / date
    | - harga / price
    | - promo
    */
    public function store(Request $request)
    {
        $productId = $request->input('product_id', $request->input('flower_id'));
        $jumlah    = $request->input('jumlah', $request->input('quantity'));
        $tanggal   = $request->input('tanggal', $request->input('date', now()->format('Y-m-d')));

        $request->merge([
            'product_id_normalized' => $productId,
            'jumlah_normalized'     => $jumlah,
            'tanggal_normalized'    => $tanggal,
        ]);

        $validated = $request->validate([
            'product_id_normalized' => 'required|integer|min:1',
            'jumlah_normalized'     => 'required|integer|min:1',
            'tanggal_normalized'    => 'required|date_format:Y-m-d',
            'harga'                 => 'nullable|numeric|min:0',
            'price'                 => 'nullable|numeric|min:0',
            'promo'                 => 'nullable',
        ]);

        $productId = (int) $validated['product_id_normalized'];
        $jumlah    = (int) $validated['jumlah_normalized'];
        $tanggal   = Carbon::parse($validated['tanggal_normalized'])->format('Y-m-d');

        $product = DB::connection('mongodb')
            ->table('products')
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Harga untuk dataset ML
        |--------------------------------------------------------------------------
        | Dataset penjualans memakai skala harga kecil seperti 56.4888,
        | bukan format rupiah besar. Jika mobile mengirim harga > 1000,
        | kita turunkan ke skala ribuan agar tetap cocok dengan dataset ML.
        */
        $harga = $request->input('harga', $request->input('price'));

        if ($harga === null) {
            $harga = (float) ($product->harga_jual ?? 0);

            if ($harga > 1000) {
                $harga = $harga / 1000;
            }
        } else {
            $harga = (float) $harga;

            if ($harga > 1000) {
                $harga = $harga / 1000;
            }
        }

        $promoInput = $request->input('promo', 0);
        $promo = filter_var($promoInput, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($promo === null) {
            $promo = (int) $promoInput === 1;
        }

        $promo = $promo ? 1 : 0;

        $lastId = DB::connection('mongodb')
            ->table('penjualans')
            ->max('id');

        $newId = ((int) $lastId) + 1;

        $transaction = [
            'id'         => $newId,
            'product_id' => $productId,
            'tanggal'    => $tanggal,
            'jumlah'     => $jumlah,
            'harga'      => $harga,
            'promo'      => $promo,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::connection('mongodb')
            ->table('penjualans')
            ->insert($transaction);

        /*
        |--------------------------------------------------------------------------
        | Update stok produk
        |--------------------------------------------------------------------------
        | Karena transaksi adalah penjualan, stok_saat_ini dikurangi jumlah.
        | Nilai stok tidak dibuat negatif.
        */
        $currentStock = (int) ($product->stok_saat_ini ?? 0);
        $newStock     = max(0, $currentStock - $jumlah);

        DB::connection('mongodb')
            ->table('products')
            ->where('id', $productId)
            ->update([
                'stok_saat_ini' => $newStock,
                'updated_at'    => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil disimpan.',
            'data'    => [
                'transaction' => $transaction,
                'stock'       => [
                    'product_id'      => $productId,
                    'stok_saat_ini'   => $newStock,
                    'stock'           => $newStock,
                ],
            ],
        ], 201);
    }
}