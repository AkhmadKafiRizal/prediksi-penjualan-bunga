<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PredictionController extends Controller
{
    public function index()
    {
        // jalankan python
        $script = base_path('machine_learning/prediction.py');
        $command = "python " . $script;
        $output = shell_exec($command);

        $data = json_decode($output, true);

        // ==============================
        // Membaca dataset dari database
        // ==============================

        $dataset = DB::table('penjualans')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $labels = [];
        $values = [];

        foreach ($dataset as $row) {
            $labels[] = count($labels) + 1;
            $values[] = (int) $row->jumlah_penjualan;
        }

        // ==============================
        // Statistik Dataset
        // ==============================

        $totalData = count($values);
        $nextPeriod = $totalData + 1;

        // ==============================
        // Periode Dataset
        // ==============================

        $first = $dataset->first();
        $last = $dataset->last();

        function formatBulanIndonesia($tahun, $bulan)
        {
            $namaBulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];

            return $namaBulan[(int)$bulan] . ' ' . $tahun;
        }

        $periodeDataset = '';

        if ($first && $last) {
            $periodeDataset =
                formatBulanIndonesia($first->tahun, $first->bulan)
                . ' – ' .
                formatBulanIndonesia($last->tahun, $last->bulan);
        }

        return view('dashboard', [
            'prediction' => $data['prediction'] ?? 0,
            'mae' => $data['mae'] ?? 0,
            'rmse' => $data['rmse'] ?? 0,
            'labels' => $labels,
            'values' => $values,

            'totalData' => $totalData,
            'nextPeriod' => $nextPeriod,

            'periodeDataset' => $periodeDataset
        ]);
    }
}