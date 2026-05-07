<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PredictionController extends Controller
{
    public function index()
    {
        $productNames = $this->getProductNames();

        $latestDate = DB::table('prediction_results')
    ->orderByDesc('updated_at')
    ->value('tanggal');

        $savedPredictions = collect();

        if ($latestDate) {
            $savedPredictions = DB::connection('mongodb')
                ->table('prediction_results')
                ->where('tanggal', $latestDate)
                ->orderBy('product_id')
                ->get();
        }

        $productPredictions = $savedPredictions->map(function ($item) use ($productNames) {
            return [
                'product_id'       => $item->product_id,
                'product_name'     => $productNames[$item->product_id] ?? ('Produk #' . $item->product_id),
                'prediction'       => $item->predicted_sales ?? 0,
                'mae'              => $item->mae ?? 0,
                'rmse'             => $item->rmse ?? 0,
                'validation_mae'   => $item->validation_mae ?? 0,
                'validation_rmse'  => $item->validation_rmse ?? 0,
            ];
        })->values();

        $predictionReady  = $productPredictions->count() > 0;
        $predictedValue   = $productPredictions->sum('prediction');
        $totalProducts    = $productPredictions->count();

        $mae             = $predictionReady ? round($productPredictions->avg('mae'), 2) : 0;
        $rmse            = $predictionReady ? round($productPredictions->avg('rmse'), 2) : 0;
        $validationMae   = $predictionReady ? round($productPredictions->avg('validation_mae'), 2) : 0;
        $validationRmse  = $predictionReady ? round($productPredictions->avg('validation_rmse'), 2) : 0;

        $topProducts = $productPredictions->sortByDesc('prediction')->take(5)->values();
        $topBars     = $productPredictions->sortByDesc('prediction')->take(10)->values();

        $dataset = DB::table('penjualans')->orderBy('tanggal')->get();
        $totalData = $dataset->count();

        $first = $dataset->first();
        $last  = $dataset->last();

        $periodeDataset = '';
        if ($first && $last) {
            $periodeDataset = date('F Y', strtotime($first->tanggal))
                . ' – '
                . date('F Y', strtotime($last->tanggal));
        }

        // ── Hitung bulan depan & label ──────────────────────────────────────
        $nextDate       = null;
        $nextMonthLabel = 'Bulan Depan';

        if ($last) {
            $nextDate = date('Y-m-d', strtotime('+1 month', strtotime($last->tanggal)));

            Carbon::setLocale('id');
            $nextMonthLabel = Carbon::parse($nextDate)->translatedFormat('F Y');
            // contoh output: "Mei 2026"
        }
        // ────────────────────────────────────────────────────────────────────

        /*
        |--------------------------------------------------------------------------
        | Perbandingan Prediksi vs Aktual
        |--------------------------------------------------------------------------
        */

        $predictionRows = DB::connection('mongodb')
            ->table('prediction_results')
            ->get();

        $predictionComparison = $predictionRows
            ->groupBy('tanggal')
            ->map(function ($rows, $tanggal) {
                $predictedSales = $rows->sum(function ($row) {
                    return $row->predicted_sales ?? 0;
                });

                $actualSales = $rows->sum(function ($row) {
                    return $row->actual_sales ?? 0;
                });

                return (object) [
                    'tanggal' => $tanggal,
                    'predicted_sales' => $predictedSales,
                    'actual_sales' => $actualSales,
                    'error' => abs($predictedSales - $actualSales),
                ];
            })
            ->sortByDesc('tanggal')
            ->take(10)
            ->values();

        return view('dashboard', [
            'prediction'           => $predictedValue,
            'mae'                  => $mae,
            'rmse'                 => $rmse,
            'validationMae'        => $validationMae,
            'validationRmse'       => $validationRmse,
            'predictionReady'      => $predictionReady,

            'totalData'            => $totalData,
            'periodeDataset'       => $periodeDataset,

            'productPredictions'   => $productPredictions,
            'totalProducts'        => $totalProducts,
            'topProducts'          => $topProducts,
            'topBars'              => $topBars,

            'predictionComparison' => $predictionComparison
        ]);
    }

    public function generate()
    {
        $script  = base_path('machine_learning/prediction.py');
        $command = "python " . escapeshellarg($script);
        $output  = shell_exec($command);
        $data    = json_decode($output, true);

        if (!is_array($data) || count($data) === 0) {
            return redirect()->route('dashboard')
                ->with('error', 'Generate prediksi gagal. Output Python tidak valid.');
        }

        $last = DB::connection('mongodb')
            ->table('penjualans')
            ->orderByDesc('tanggal')
            ->first();

        if (!$last) {
            return redirect()->route('dashboard')
                ->with('error', 'Dataset penjualan belum tersedia.');
        }

        $nextDate = date('Y-m-d', strtotime('+1 month', strtotime($last->tanggal)));

        foreach ($data as $item) {
            $productId = $item['product_id'] ?? null;

            if (!$productId) {
                continue;
            }

            DB::table('prediction_results')->updateOrInsert(
                [
                    'tanggal' => $nextDate,
                    'product_id' => $productId,
                ],
                [
                    'predicted_sales' => $item['prediction'] ?? 0,
                    'actual_sales' => DB::table('penjualans')
                        ->where('tanggal', $nextDate)
                        ->where('product_id', $productId)
                        ->sum('jumlah'),
                    'mae' => $item['mae'] ?? null,
                    'rmse' => $item['rmse'] ?? null,
                    'validation_mae' => $item['validation_mae'] ?? null,
                    'validation_rmse' => $item['validation_rmse'] ?? null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return redirect()->route('dashboard')
            ->with('success', 'Prediksi berhasil digenerate dan disimpan ke MongoDB.');
    }

    private function getProductNames()
    {
        return DB::connection('mongodb')
            ->table('products')
            ->pluck('nama_bunga', 'id')
            ->toArray();
    }
}