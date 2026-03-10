<?php

namespace App\Http\Controllers;

class SalesController extends Controller
{
    public function index()
    {
        $file = base_path('dataset/cleaned_flower_sales_dataset.csv');

        $rows = [];
        $header = [];

        if (($handle = fopen($file, 'r')) !== false) {

            $header = fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }

            fclose($handle);
        }

        return view('sales', [
            'header' => $header,
            'rows' => $rows
        ]);
    }
}