<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ImportPenjualanController extends Controller
{
    public function import()
    {
        $path = base_path('dataset/cleaned_flower_sales_dataset.csv');

        if (!file_exists($path)) {
            return "File CSV tidak ditemukan.";
        }

        $file = fopen($path, 'r');

        // skip header
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {

            // contoh YEAR_MONTH = 2003-01
            $yearMonth = $row[0];

            // pecah menjadi tahun dan bulan
            [$tahun, $bulan] = explode('-', $yearMonth);

            DB::table('penjualans')->insert([
                'bulan' => (int)$bulan,
                'tahun' => (int)$tahun,
                'jumlah_penjualan' => (int)$row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);

        return "Import dataset berhasil.";
    }
}