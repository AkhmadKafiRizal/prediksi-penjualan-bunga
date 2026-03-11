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

        return view('dashboard', [
            'prediction' => $data['prediction'] ?? 0,
            'mae' => $data['mae'] ?? 0,
            'rmse' => $data['rmse'] ?? 0,
            'labels' => $labels,
            'values' => $values
        ]);
    }
}