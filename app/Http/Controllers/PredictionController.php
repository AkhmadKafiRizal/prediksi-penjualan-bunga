<?php

namespace App\Http\Controllers;

class PredictionController extends Controller
{
    public function index()
    {
        $script = base_path('machine_learning/prediction.py');

        $command = "python " . $script;

        $output = shell_exec($command);

        $data = json_decode($output, true);

        return view('dashboard', [
            'prediction' => $data['prediction'] ?? 0,
            'mae' => $data['mae'] ?? 0,
            'rmse' => $data['rmse'] ?? 0
        ]);
    }
}