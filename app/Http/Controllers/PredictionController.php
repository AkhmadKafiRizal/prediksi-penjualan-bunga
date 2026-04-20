<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PredictionController extends Controller
{
    public function index()
    {

        // Jalankan Python Script
        $script = base_path('machine_learning/prediction.py');
        $command = "python " . $script;
        $output  = shell_exec($command);
        $data    = json_decode($output, true);

        // Hitung Total Prediksi dari semua produk
        $totalPrediction = 0;
        $mae = 0;
        $rmse = 0;

        if (is_array($data)) {
            foreach ($data as $item) {
                $totalPrediction += $item['prediction'] ?? 0;
                $mae = $item['mae'] ?? 0;
                $rmse = $item['rmse'] ?? 0;
            }
        }

        $predictedValue = $totalPrediction;

        // Dataset FULL untuk statistik
        $dataset = DB::table('penjualans')
            ->orderBy('tanggal')
            ->get();

        // Dataset TERBATAS untuk grafik
        $chartDataset = DB::table('penjualans')
            ->orderBy('tanggal')
            ->limit(200)
            ->get();

        $labels = [];
        $values = [];

        foreach ($chartDataset as $row) {
            $labels[] = count($labels) + 1;
            $values[] = (int) $row->jumlah;
        }

        // Statistik Dataset
        $totalData = $dataset->count();
        $nextPeriod = $totalData + 1;

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

        // Simpan hasil prediksi
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

        return view('dashboard', [

            'prediction' => $predictedValue,
            'mae' => $mae,
            'rmse' => $rmse,

            'labels' => $labels,
            'values' => $values,

            'totalData' => $totalData,
            'nextPeriod' => $nextPeriod,
            'periodeDataset' => $periodeDataset,

            'predictionComparison' => $predictionComparison
        ]);
    }
}