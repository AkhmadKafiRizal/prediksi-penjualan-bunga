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

        // ==============================
        // Ambil waktu upload dataset
        // ==============================

        $timeFile = storage_path('app/dataset_time.txt');
        $lastUpload = null;

        if (file_exists($timeFile)) {
            $lastUpload = file_get_contents($timeFile);
        }

        return view('sales', [
            'header' => $header,
            'rows' => $rows,
            'lastUpload' => $lastUpload
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

        // ==============================
        // Simpan waktu upload dataset
        // ==============================

        $timeFile = storage_path('app/dataset_time.txt');

        file_put_contents(
            $timeFile,
            date('d-m-Y H:i:s')
        );

        return redirect()->route('sales')
            ->with('success', 'Dataset berhasil diperbarui');
    }
}