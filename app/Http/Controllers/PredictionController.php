<?php

namespace App\Http\Controllers;

class PredictionController extends Controller
{
    public function index()
    {
        // jalankan python
        $script = base_path('machine_learning/prediction.py');
        $command = "python " . $script;
        $output = shell_exec($command);

        $data = json_decode($output, true);

        // membaca dataset untuk grafik
        $file = base_path('dataset/cleaned_flower_sales_dataset.csv');

        $labels = [];
        $values = [];

        if (($handle = fopen($file, 'r')) !== false) {

            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {

                $labels[] = count($labels) + 1;
                $values[] = (int)$row[1]; // kolom QUANTITYORDERED
            }

            fclose($handle);
        }

        // ==============================
        // Statistik Dataset
        // ==============================

        $totalData = count($values);
        $nextPeriod = $totalData + 1;

        // ==============================
        // TAMBAHAN: Periode Dataset
        // ==============================

        $firstYearMonth = null;
        $lastYearMonth = null;

        if (($handle = fopen($file, 'r')) !== false) {

            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {

                $yearMonth = $row[0]; // kolom YEAR_MONTH

                if ($firstYearMonth === null) {
                    $firstYearMonth = $yearMonth;
                }

                $lastYearMonth = $yearMonth;
            }

            fclose($handle);
        }

        function formatBulanIndonesia($yearMonth)
        {
            if (!$yearMonth) return '';

            [$year, $month] = explode('-', $yearMonth);

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

            return $namaBulan[(int)$month] . ' ' . $year;
        }

        $periodeDataset =
            formatBulanIndonesia($firstYearMonth)
            . ' – ' .
            formatBulanIndonesia($lastYearMonth);

        return view('dashboard', [
            'prediction' => $data['prediction'] ?? 0,
            'mae' => $data['mae'] ?? 0,
            'rmse' => $data['rmse'] ?? 0,
            'labels' => $labels,
            'values' => $values,

            'totalData' => $totalData,
            'nextPeriod' => $nextPeriod,

            // TAMBAHAN
            'periodeDataset' => $periodeDataset
        ]);
    }
}