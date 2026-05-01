<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PredictionApiController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil hasil prediksi terbaru dari MongoDB
        |--------------------------------------------------------------------------
        | Tidak memakai SQL alias / join karena data sudah berada di MongoDB.
        */

        $latestDate = DB::connection('mongodb')
            ->table('prediction_results')
            ->orderByDesc('updated_at')
            ->value('tanggal');

        if (!$latestDate) {
            return response()->json([]);
        }

        $predictions = DB::connection('mongodb')
            ->table('prediction_results')
            ->where('tanggal', $latestDate)
            ->orderBy('product_id', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil nama produk dari collection products
        |--------------------------------------------------------------------------
        | Join SQL diganti dengan mapping manual product_id => nama_bunga.
        */

        $productNames = DB::connection('mongodb')
            ->table('products')
            ->pluck('nama_bunga', 'id');

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