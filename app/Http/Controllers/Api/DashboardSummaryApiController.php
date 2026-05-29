<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardSummaryApiController extends Controller
{
    public function index()
    {
        $mongo = DB::connection('mongodb');

        $transactions = $mongo->table('penjualans')->count();
        $activeProducts = $mongo->table('products')
            ->get(['id', 'stok_saat_ini', 'stok_minimum', 'is_active'])
            ->filter(fn ($product) => (int) ($product->is_active ?? 1) === 1)
            ->values();

        $activeProductIds = $activeProducts
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        $flowerTypes = $activeProducts->count();
        $lowStock = $activeProducts->filter(function ($product) {
            return (int) ($product->stok_saat_ini ?? 0) <= (int) ($product->stok_minimum ?? 0);
        })->count();

        /*
        |--------------------------------------------------------------------------
        | Ambil total prediksi terbaru
        |--------------------------------------------------------------------------
        | prediction_results punya beberapa tanggal prediksi.
        | Untuk ringkasan dashboard mobile, kita ambil tanggal prediksi terbaru,
        | lalu jumlahkan seluruh predicted_sales pada tanggal tersebut.
        */
        $latestPrediction = null;

        if (! empty($activeProductIds)) {
            $latestPrediction = $mongo->table('prediction_results')
                ->whereIn('product_id', $activeProductIds)
                ->orderBy('tanggal', 'desc')
                ->first();
        }

        $totalPrediction = 0;

        if ($latestPrediction) {
            $latestPredictionDate = $latestPrediction->tanggal;

            $predictionRows = $mongo->table('prediction_results')
                ->where('tanggal', $latestPredictionDate)
                ->whereIn('product_id', $activeProductIds)
                ->get();

            $totalPrediction = $predictionRows->sum(function ($row) {
                return (int) ($row->predicted_sales ?? 0);
            });
        }

        return response()->json([
            'success' => true,
            'data' => [
                'transactions' => $transactions,
                'revenue' => 0,
                'flower_types' => $flowerTypes,
                'low_stock' => $lowStock,
                'total_prediction' => $totalPrediction,
            ],
        ]);
    }
}
