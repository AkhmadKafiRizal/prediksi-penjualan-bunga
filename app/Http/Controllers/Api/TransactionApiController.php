<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        $query = DB::connection('mongodb')->table('penjualans');

        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->query('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->query('end_date'));
        }

        $total = (clone $query)->count();

        $rows = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
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

            $displayId = $row->transaction_number
                ?? $row->id
                ?? (isset($row->_id) ? (string) $row->_id : null);

            return [
                'id'                 => $displayId,
                'transaction_number' => $row->transaction_number ?? $displayId,
                'invoice_number'     => $row->invoice_number ?? ('TRX-' . $displayId),

                'product_id'         => $productId,
                'flower_id'          => $productId,

                'nama_bunga'         => $product->nama_bunga ?? 'Produk #' . $productId,
                'product_name'       => $product->nama_bunga ?? 'Produk #' . $productId,
                'flower_name'        => $product->nama_bunga ?? 'Produk #' . $productId,

                'tanggal'            => $row->tanggal ?? null,
                'date'               => $row->tanggal ?? null,

                'jumlah'             => (int) ($row->jumlah ?? 0),
                'quantity'           => (int) ($row->jumlah ?? 0),

                'harga'              => (float) ($row->harga ?? 0),
                'price'              => (float) ($row->harga ?? 0),
                'unit_price'         => (float) ($row->harga ?? 0),

                'promo'              => (int) ($row->promo ?? 0),
                'kasir_id'           => $row->kasir_id ?? $row->cashier_id ?? null,
                'kasir_name'         => $row->kasir_name ?? $row->cashier_name ?? 'Data historis',
                'cashier_id'         => $row->kasir_id ?? $row->cashier_id ?? null,
                'cashier_name'       => $row->kasir_name ?? $row->cashier_name ?? 'Data historis',
                'payment_method'     => $row->payment_method ?? null,
                'amount_paid'        => (float) ($row->amount_paid ?? 0),
                'total_amount'       => (float) ($row->total_amount ?? 0),
                'grand_total'        => (float) ($row->grand_total ?? 0),
                'change'             => (float) ($row->change ?? 0),

                'source'             => $row->source ?? null,
                'created_at'         => $row->created_at ?? null,
                'updated_at'         => $row->updated_at ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil diambil.',
            'data'    => $data,
            'meta'    => [
                'page'     => $page,
                'per_page' => $perPage,
                'total'    => $total,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | POST /api/transactions
    |--------------------------------------------------------------------------
    | Mendukung 2 format:
    |
    | 1. Format checkout mobile:
    |    {
    |      "items": [
    |        {"flower_id":1,"quantity":3,"unit_price":10000}
    |      ],
    |      "payment_method":"cash",
    |      "amount_paid":30000
    |    }
    |
    | 2. Format single test:
    |    {
    |      "product_id":1,
    |      "tanggal":"2026-05-17",
    |      "jumlah":1,
    |      "harga":56.4888,
    |      "promo":0
    |    }
    */
    public function store(Request $request)
    {
        if ($request->has('items') && is_array($request->input('items'))) {
            return $this->storeCartTransaction($request);
        }

        return $this->storeSingleTransaction($request);
    }

    private function storeCartTransaction(Request $request)
    {
        $validated = $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.flower_id'  => 'nullable|integer|min:1',
            'items.*.product_id' => 'nullable|integer|min:1',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.price'      => 'nullable|numeric|min:0',

            'payment_method'     => 'nullable|string',
            'amount_paid'        => 'nullable|numeric|min:0',
            'total_amount'       => 'nullable|numeric|min:0',
            'grand_total'        => 'nullable|numeric|min:0',
            'change'             => 'nullable|numeric|min:0',
            'note'               => 'nullable|string',
            'promo'              => 'nullable',
            'kasir_id'           => 'nullable|string|max:100',
            'kasir_name'         => 'nullable|string|max:150',
            'kasir_email'        => 'nullable|email|max:150',
            'cashier_id'         => 'nullable|string|max:100',
            'cashier_name'       => 'nullable|string|max:150',
            'cashier_email'      => 'nullable|email|max:150',
            'user_id'            => 'nullable|string|max:100',
            'user_name'          => 'nullable|string|max:150',
        ]);

        $tanggal = now()->format('Y-m-d');
        $now     = now();

        $products = DB::connection('mongodb')
            ->table('products')
            ->get()
            ->keyBy('id');

        /*
         | Jangan pakai field "id" untuk dokumen baru.
         | Pada mongodb/laravel-mongodb, field "id" bisa bentrok dengan "_id".
         | Karena itu kita pakai transaction_number sebagai nomor urut transaksi.
         */
        $lastTransactionNumber = (int) DB::connection('mongodb')
            ->table('penjualans')
            ->max('transaction_number');

        if ($lastTransactionNumber <= 0) {
            $lastLegacyId = (int) DB::connection('mongodb')
                ->table('penjualans')
                ->max('id');

            $lastTransactionNumber = $lastLegacyId;
        }

        $insertedTransactions = [];
        $updatedStocks = [];

        $totalAmount = (float) $request->input(
            'total_amount',
            $request->input('grand_total', 0)
        );

        $grandTotal = (float) $request->input(
            'grand_total',
            $request->input('total_amount', $totalAmount)
        );

        $amountPaid = (float) $request->input('amount_paid', 0);
        $change     = max(0, $amountPaid - $grandTotal);
        $cashier     = $this->cashierPayload($request);
        $promoInput  = $request->input('promo', 0);
        $promo       = filter_var($promoInput, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($promo === null) {
            $promo = (int) $promoInput === 1;
        }

        $promo = $promo ? 1 : 0;

        foreach ($validated['items'] as $item) {
            $productId = (int) ($item['product_id'] ?? $item['flower_id'] ?? 0);
            $jumlah    = (int) ($item['quantity'] ?? 0);

            if ($productId <= 0 || $jumlah <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data item transaksi tidak valid.',
                ], 422);
            }

            $product = $products->get($productId);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk dengan ID ' . $productId . ' tidak ditemukan.',
                ], 404);
            }

            if (! $this->productIsActive($product)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk ' . ($product->nama_bunga ?? $productId) . ' sedang nonaktif dan tidak bisa dipakai untuk transaksi baru.',
                ], 422);
            }

            $currentStock = (int) ($product->stok_saat_ini ?? 0);

            if ($currentStock < $jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk ' . ($product->nama_bunga ?? $productId) . ' tidak mencukupi.',
                ], 422);
            }

            $harga = $item['unit_price'] ?? $item['price'] ?? ($product->harga_jual ?? 0);
            $harga = (float) $harga;

            /*
             | Dataset ML memakai skala kecil.
             | Jika mobile mengirim harga Rupiah seperti 10000,
             | simpan ke penjualans sebagai 10 agar skala tetap konsisten.
             */
            if ($harga > 1000) {
                $harga = $harga / 1000;
            }

            $lastTransactionNumber++;

            $transactionNumber = $lastTransactionNumber;
            $invoiceNumber     = 'TRX-' . $now->format('YmdHis') . '-' . $transactionNumber;

            $transaction = [
                'transaction_number' => $transactionNumber,
                'invoice_number'     => $invoiceNumber,

                'product_id'         => $productId,
                'tanggal'            => $tanggal,
                'jumlah'             => $jumlah,
                'harga'              => $harga,
                'promo'              => $promo,

                'kasir_id'           => $cashier['kasir_id'],
                'kasir_name'         => $cashier['kasir_name'],
                'kasir_email'        => $cashier['kasir_email'],
                'cashier_id'         => $cashier['kasir_id'],
                'cashier_name'       => $cashier['kasir_name'],
                'cashier_email'      => $cashier['kasir_email'],

                'payment_method'     => $request->input('payment_method', 'cash'),
                'amount_paid'        => $amountPaid,
                'total_amount'       => $totalAmount,
                'grand_total'        => $grandTotal,
                'change'             => $change,

                'note'               => $request->input('note'),
                'source'             => 'mobile',
                'created_at'         => $now,
                'updated_at'         => $now,
            ];

            DB::connection('mongodb')
                ->table('penjualans')
                ->insert($transaction);

            $newStock = max(0, $currentStock - $jumlah);

            DB::connection('mongodb')
                ->table('products')
                ->where('id', $productId)
                ->update([
                    'stok_saat_ini' => $newStock,
                    'updated_at'    => $now,
                ]);

            $insertedTransactions[] = $transaction;

            $updatedStocks[] = [
                'product_id'    => $productId,
                'flower_id'     => $productId,
                'nama_bunga'    => $product->nama_bunga ?? 'Produk #' . $productId,
                'flower_name'   => $product->nama_bunga ?? 'Produk #' . $productId,
                'stok_saat_ini' => $newStock,
                'stock'         => $newStock,
            ];
        }

        $firstTransaction = $insertedTransactions[0] ?? null;

        return response()->json([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil disimpan.',
            'data'    => [
                'id'                 => $firstTransaction['transaction_number'] ?? null,
                'transaction_number' => $firstTransaction['transaction_number'] ?? null,
                'invoice_number'     => $firstTransaction['invoice_number'] ?? null,

                'transaction'        => $firstTransaction,
                'transactions'       => $insertedTransactions,
                'stocks'             => $updatedStocks,

                'total_items'        => count($insertedTransactions),
                'payment_method'     => $request->input('payment_method', 'cash'),
                'total_amount'       => $totalAmount,
                'grand_total'        => $grandTotal,
                'amount_paid'        => $amountPaid,
                'change'             => $change,
                'created_at'         => $now,
            ],
        ], 201);
    }

    private function storeSingleTransaction(Request $request)
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
            'kasir_id'              => 'nullable|string|max:100',
            'kasir_name'            => 'nullable|string|max:150',
            'kasir_email'           => 'nullable|email|max:150',
            'cashier_id'            => 'nullable|string|max:100',
            'cashier_name'          => 'nullable|string|max:150',
            'cashier_email'         => 'nullable|email|max:150',
            'user_id'               => 'nullable|string|max:100',
            'user_name'             => 'nullable|string|max:150',
        ]);

        $productId = (int) $validated['product_id_normalized'];
        $jumlah    = (int) $validated['jumlah_normalized'];
        $tanggal   = Carbon::parse($validated['tanggal_normalized'])->format('Y-m-d');
        $now       = now();

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

        if (! $this->productIsActive($product)) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sedang nonaktif dan tidak bisa dipakai untuk transaksi baru.',
            ], 422);
        }

        $currentStock = (int) ($product->stok_saat_ini ?? 0);

        if ($currentStock < $jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi.',
            ], 422);
        }

        $harga = $request->input('harga', $request->input('price'));

        if ($harga === null) {
            $harga = (float) ($product->harga_jual ?? 0);
        } else {
            $harga = (float) $harga;
        }

        if ($harga > 1000) {
            $harga = $harga / 1000;
        }

        $promoInput = $request->input('promo', 0);
        $promo = filter_var($promoInput, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($promo === null) {
            $promo = (int) $promoInput === 1;
        }

        $promo = $promo ? 1 : 0;

        $lastTransactionNumber = (int) DB::connection('mongodb')
            ->table('penjualans')
            ->max('transaction_number');

        if ($lastTransactionNumber <= 0) {
            $lastLegacyId = (int) DB::connection('mongodb')
                ->table('penjualans')
                ->max('id');

            $lastTransactionNumber = $lastLegacyId;
        }

        $transactionNumber = $lastTransactionNumber + 1;
        $invoiceNumber     = 'TRX-' . $now->format('YmdHis') . '-' . $transactionNumber;
        $cashier           = $this->cashierPayload($request);

        $transaction = [
            'transaction_number' => $transactionNumber,
            'invoice_number'     => $invoiceNumber,

            'product_id'         => $productId,
            'tanggal'            => $tanggal,
            'jumlah'             => $jumlah,
            'harga'              => $harga,
            'promo'              => $promo,

            'kasir_id'           => $cashier['kasir_id'],
            'kasir_name'         => $cashier['kasir_name'],
            'kasir_email'        => $cashier['kasir_email'],
            'cashier_id'         => $cashier['kasir_id'],
            'cashier_name'       => $cashier['kasir_name'],
            'cashier_email'      => $cashier['kasir_email'],

            'source'             => 'mobile',
            'created_at'         => $now,
            'updated_at'         => $now,
        ];

        DB::connection('mongodb')
            ->table('penjualans')
            ->insert($transaction);

        $newStock = max(0, $currentStock - $jumlah);

        DB::connection('mongodb')
            ->table('products')
            ->where('id', $productId)
            ->update([
                'stok_saat_ini' => $newStock,
                'updated_at'    => $now,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil disimpan.',
            'data'    => [
                'id'                 => $transactionNumber,
                'transaction_number' => $transactionNumber,
                'invoice_number'     => $invoiceNumber,

                'transaction'        => $transaction,
                'stock'              => [
                    'product_id'    => $productId,
                    'flower_id'     => $productId,
                    'stok_saat_ini' => $newStock,
                    'stock'         => $newStock,
                ],
            ],
        ], 201);
    }

    private function productIsActive($product): bool
    {
        return (int) ($product->is_active ?? 1) === 1;
    }

    private function cashierPayload(Request $request): array
    {
        $authenticatedCashier = $this->authenticatedCashier($request);

        if ($authenticatedCashier) {
            return [
                'kasir_id'    => (string) ($authenticatedCashier->_id ?? $authenticatedCashier->id),
                'kasir_name'  => $authenticatedCashier->name,
                'kasir_email' => $authenticatedCashier->email,
            ];
        }

        $kasirId = $request->input('kasir_id')
            ?? $request->input('cashier_id')
            ?? $request->input('user_id')
            ?? $request->input('user.id')
            ?? $request->input('cashier.id');

        $kasirName = $request->input('kasir_name')
            ?? $request->input('cashier_name')
            ?? $request->input('user_name')
            ?? $request->input('user.name')
            ?? $request->input('cashier.name');

        $kasirEmail = $request->input('kasir_email')
            ?? $request->input('cashier_email')
            ?? $request->input('user.email')
            ?? $request->input('cashier.email');

        return [
            'kasir_id'    => $kasirId ? (string) $kasirId : null,
            'kasir_name'  => $kasirName ? trim((string) $kasirName) : null,
            'kasir_email' => $kasirEmail ? trim((string) $kasirEmail) : null,
        ];
    }

    private function authenticatedCashier(Request $request): ?User
    {
        $token = $request->bearerToken() ?: $request->input('token');

        if (!$token) {
            return null;
        }

        return User::where('api_token', hash('sha256', $token))
            ->where('role', 'kasir')
            ->where('status', 'aktif')
            ->first();
    }
}
