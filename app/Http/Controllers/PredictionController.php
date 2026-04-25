<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PredictionController extends Controller
{
    public function index()
    {
        // Jalankan Python Script
        $script = base_path('machine_learning/prediction.py');
        $command = "python " . escapeshellarg($script);
        $output  = shell_exec($command);
        $data    = json_decode($output, true);

        // Default value
        $totalPrediction = 0;
        $mae = 0;
        $rmse = 0;
        $validationMae = 0;
        $validationRmse = 0;
        $predictionReady = false;

        // Ambil nama produk jika tabel products tersedia
        $productNames = collect();

        if (Schema::hasTable('products')) {
            if (Schema::hasColumn('products', 'nama_bunga')) {
                $productNames = DB::table('products')->pluck('nama_bunga', 'id');
            } elseif (Schema::hasColumn('products', 'name')) {
                $productNames = DB::table('products')->pluck('name', 'id');
            } elseif (Schema::hasColumn('products', 'nama')) {
                $productNames = DB::table('products')->pluck('nama', 'id');
            }
        }

        // Baca output Python format array per produk
        if (is_array($data) && count($data) > 0) {
            $predictionReady = true;

            $totalMae = 0;
            $totalRmse = 0;
            $totalValidationMae = 0;
            $totalValidationRmse = 0;
            $count = 0;

            foreach ($data as $item) {
                $totalPrediction += $item['prediction'] ?? 0;

                $totalMae += $item['mae'] ?? 0;
                $totalRmse += $item['rmse'] ?? 0;
                $totalValidationMae += $item['validation_mae'] ?? 0;
                $totalValidationRmse += $item['validation_rmse'] ?? 0;

                $count++;
            }

            if ($count > 0) {
                $mae = round($totalMae / $count, 2);
                $rmse = round($totalRmse / $count, 2);
                $validationMae = round($totalValidationMae / $count, 2);
                $validationRmse = round($totalValidationRmse / $count, 2);
            }
        }

        $productPredictions = collect($data ?? [])->map(function ($item) use ($productNames) {
            $productId = $item['product_id'] ?? null;

            return [
                'product_id' => $productId,
                'product_name' => $productNames[$productId] ?? ('Produk #' . ($productId ?? '-')),
                'prediction' => $item['prediction'] ?? 0,
                'mae' => $item['mae'] ?? 0,
                'rmse' => $item['rmse'] ?? 0,
                'validation_mae' => $item['validation_mae'] ?? 0,
                'validation_rmse' => $item['validation_rmse'] ?? 0,
            ];
        })->values();

        $totalProducts = $productPredictions->count();

        $topProducts = $productPredictions
            ->sortByDesc('prediction')
            ->take(5)
            ->values();

        $topBars = $productPredictions
            ->sortByDesc('prediction')
            ->take(10)
            ->values();

        $predictedValue = $totalPrediction;

        // Dataset FULL untuk statistik
        $dataset = DB::table('penjualans')
            ->orderBy('tanggal')
            ->get();

        $totalData = $dataset->count();

        // Periode Dataset
        $first = $dataset->first();
        $last = $dataset->last();

        $periodeDataset = '';

        if ($first && $last) {
            $firstDate = strtotime($first->tanggal);
            $lastDate = strtotime($last->tanggal);

            $periodeDataset =
                date('F Y', $firstDate)
                . ' – ' .
                date('F Y', $lastDate);
        }

        // Tentukan tanggal prediksi berikutnya
        $nextDate = null;

        if ($last) {
            $lastDate = strtotime($last->tanggal);
            $nextDate = date('Y-m-d', strtotime('+1 month', $lastDate));
        }

        // Simpan hasil prediksi agregasi semua produk
        if ($nextDate && $predictedValue > 0) {
            DB::table('prediction_results')->updateOrInsert(
                [
                    'tanggal' => $nextDate,
                    'product_id' => 1
                ],
                [
                    'predicted_sales' => $predictedValue,
                    'updated_at' => now()
                ]
            );
        }

        // Sinkronisasi Actual Sales (AGREGASI)
        $actualData = DB::table('penjualans')
            ->select('tanggal', DB::raw('SUM(jumlah) as total_sales'))
            ->groupBy('tanggal')
            ->get();

        foreach ($actualData as $row) {
            DB::table('prediction_results')
                ->where('tanggal', $row->tanggal)
                ->update([
                    'actual_sales' => $row->total_sales
                ]);
        }

        // Ambil data Prediksi vs Real
        $predictionComparison = DB::table('prediction_results')
            ->select(
                'tanggal',
                'predicted_sales',
                'actual_sales',
                DB::raw('ABS(predicted_sales - actual_sales) as error')
            )
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'prediction' => $predictedValue,
            'mae' => $mae,
            'rmse' => $rmse,
            'validationMae' => $validationMae,
            'validationRmse' => $validationRmse,
            'predictionReady' => $predictionReady,

            'totalData' => $totalData,
            'periodeDataset' => $periodeDataset,

            'productPredictions' => $productPredictions,
            'totalProducts' => $totalProducts,
            'topProducts' => $topProducts,
            'topBars' => $topBars,

            'predictionComparison' => $predictionComparison
        ]);
    }
}