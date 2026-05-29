<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PredictionApiController extends Controller
{
    public function index()
    {
        $activeProducts = DB::connection('mongodb')
            ->table('products')
            ->get(['id', 'nama_bunga', 'is_active'])
            ->filter(fn ($product) => (int) ($product->is_active ?? 1) === 1)
            ->values();

        $activeProductIds = $activeProducts
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        if (empty($activeProductIds)) {
            return response()->json([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil hasil prediksi terbaru dari MongoDB
        |--------------------------------------------------------------------------
        | Tidak memakai SQL alias / join karena data sudah berada di MongoDB.
        */

        $latestDate = DB::connection('mongodb')
            ->table('prediction_results')
            ->whereIn('product_id', $activeProductIds)
            ->orderByDesc('tanggal')
            ->value('tanggal');

        if (!$latestDate) {
            return response()->json([]);
        }

        $predictions = DB::connection('mongodb')
            ->table('prediction_results')
            ->where('tanggal', $latestDate)
            ->whereIn('product_id', $activeProductIds)
            ->orderBy('product_id', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil nama produk dari collection products
        |--------------------------------------------------------------------------
        | Join SQL diganti dengan mapping manual product_id => nama_bunga.
        */

        $productNames = $activeProducts->pluck('nama_bunga', 'id');

        /*
        |--------------------------------------------------------------------------
        | Format JSON untuk mobile
        |--------------------------------------------------------------------------
        */

        $result = $predictions->map(function ($item) use ($productNames) {
            return [
                'product_id' => (int) $item->product_id,
                'nama_bunga' => $productNames[$item->product_id] ?? 'Produk #' . $item->product_id,
                'prediction' => (int) ($item->predicted_sales ?? 0),
                'tanggal' => $item->tanggal ?? null,
            ];
        })->values();

        return response()->json($result);
    }
}
