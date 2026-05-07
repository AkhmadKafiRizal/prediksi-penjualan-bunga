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
        $flowerTypes = $mongo->table('products')->count();

        /*
        |--------------------------------------------------------------------------
        | Ambil total prediksi terbaru
        |--------------------------------------------------------------------------
        | prediction_results punya beberapa tanggal prediksi.
        | Untuk ringkasan dashboard mobile, kita ambil tanggal prediksi terbaru,
        | lalu jumlahkan seluruh predicted_sales pada tanggal tersebut.
        */
        $latestPrediction = $mongo->table('prediction_results')
            ->orderBy('tanggal', 'desc')
            ->first();

        $totalPrediction = 0;

        if ($latestPrediction) {
            $latestPredictionDate = $latestPrediction->tanggal;

            $predictionRows = $mongo->table('prediction_results')
                ->where('tanggal', $latestPredictionDate)
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
                'low_stock' => 0,
                'total_prediction' => $totalPrediction,
            ],
        ]);
    }
}