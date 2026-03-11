<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function upload(Request $request)
    {
        $request->validate([
            'dataset' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('dataset');

        $destination = base_path('dataset');

        $file->move($destination, 'cleaned_flower_sales_dataset.csv');

        return redirect()->route('sales')
            ->with('success', 'Dataset berhasil diperbarui');
    }
}