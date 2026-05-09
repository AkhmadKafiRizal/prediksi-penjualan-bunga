<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PredictionController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Mapping Nama Produk
        |--------------------------------------------------------------------------
        | Data prediction_results hanya menyimpan product_id.
        | Karena itu nama bunga diambil dari collection products agar dashboard
        | bisa menampilkan nama produk yang mudah dibaca.
        |--------------------------------------------------------------------------
        */

        $productNames = $this->getProductNames();

        /*
        |--------------------------------------------------------------------------
        | Ambil Tanggal Prediksi Terbaru
        |--------------------------------------------------------------------------
        | Dashboard hanya menampilkan hasil prediksi terbaru.
        | Data diambil dari MongoDB collection prediction_results.
        |--------------------------------------------------------------------------
        */

        $latestDate = DB::connection('mongodb')
            ->table('prediction_results')
            ->orderByDesc('updated_at')
            ->value('tanggal');

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Prediksi yang Sudah Tersimpan
        |--------------------------------------------------------------------------
        | Jika sudah ada tanggal prediksi terbaru, ambil seluruh hasil prediksi
        | pada tanggal tersebut, lalu urutkan berdasarkan product_id.
        |--------------------------------------------------------------------------
        */

        $savedPredictions = collect();

        if ($latestDate) {
            $savedPredictions = DB::connection('mongodb')
                ->table('prediction_results')
                ->where('tanggal', $latestDate)
                ->orderBy('product_id')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Format Data Prediksi Per Produk
        |--------------------------------------------------------------------------
        | Data dari MongoDB diformat ulang agar mudah dipakai oleh dashboard.
        | Bagian ini juga memasangkan product_id dengan nama bunga.
        |--------------------------------------------------------------------------
        */

        $productPredictions = $savedPredictions->map(function ($item) use ($productNames) {
            $productId = $item->product_id ?? null;

            return [
                'product_id'       => $productId,
                'product_name'     => $productNames[$productId] ?? ('Produk #' . $productId),
                'prediction'       => $item->predicted_sales ?? 0,
                'mae'              => $item->mae ?? 0,
                'rmse'             => $item->rmse ?? 0,
                'validation_mae'   => $item->validation_mae ?? 0,
                'validation_rmse'  => $item->validation_rmse ?? 0,
            ];
        })->values();

        /*
        |--------------------------------------------------------------------------
        | Ringkasan Hasil Prediksi
        |--------------------------------------------------------------------------
        | Bagian ini menghitung total prediksi, jumlah produk yang diprediksi,
        | serta rata-rata nilai evaluasi MAE dan RMSE.
        |--------------------------------------------------------------------------
        */

        $predictionReady = $productPredictions->count() > 0;
        $predictedValue  = $productPredictions->sum('prediction');
        $totalProducts   = $productPredictions->count();

        $mae = $predictionReady
            ? round($productPredictions->avg('mae'), 2)
            : 0;

        $rmse = $predictionReady
            ? round($productPredictions->avg('rmse'), 2)
            : 0;

        $validationMae = $predictionReady
            ? round($productPredictions->avg('validation_mae'), 2)
            : 0;

        $validationRmse = $predictionReady
            ? round($productPredictions->avg('validation_rmse'), 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Produk dengan Prediksi Tertinggi
        |--------------------------------------------------------------------------
        | topProducts digunakan untuk daftar ringkas produk teratas.
        | topBars digunakan untuk grafik/bar chart pada dashboard.
        |--------------------------------------------------------------------------
        */

        $topProducts = $productPredictions
            ->sortByDesc('prediction')
            ->take(5)
            ->values();

        $topBars = $productPredictions
            ->sortByDesc('prediction')
            ->take(10)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Informasi Dataset Penjualan
        |--------------------------------------------------------------------------
        | Mengambil dataset penjualan dari MongoDB untuk menampilkan total data
        | dan periode dataset pada dashboard.
        |--------------------------------------------------------------------------
        */

        $dataset = DB::connection('mongodb')
            ->table('penjualans')
            ->orderBy('tanggal')
            ->get();

        $totalData = $dataset->count();

        $first = $dataset->first();
        $last  = $dataset->last();

        $periodeDataset = '-';

        if ($first && $last) {
            Carbon::setLocale('id');

            $periodeDataset = Carbon::parse($first->tanggal)->translatedFormat('F Y')
                . ' – '
                . Carbon::parse($last->tanggal)->translatedFormat('F Y');
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung Bulan Depan dan Label Prediksi
        |--------------------------------------------------------------------------
        | Prediksi dihitung untuk periode setelah tanggal terakhir dataset.
        | Contoh: jika data terakhir Desember 2023, maka prediksi untuk Januari 2024.
        |--------------------------------------------------------------------------
        */

        $nextDate = null;
        $nextMonthLabel = 'Bulan Depan';

        if ($last) {
            Carbon::setLocale('id');

            $nextDate = Carbon::parse($last->tanggal)
                ->addMonth()
                ->format('Y-m-d');

            $nextMonthLabel = Carbon::parse($nextDate)
                ->translatedFormat('F Y');
        }

        /*
        |--------------------------------------------------------------------------
        | Perbandingan Prediksi vs Aktual
        |--------------------------------------------------------------------------
        | Mengelompokkan data prediction_results berdasarkan tanggal.
        | Bagian ini dipakai untuk menampilkan perbandingan total prediksi,
        | total aktual, dan selisih error pada dashboard.
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
                    'tanggal'         => $tanggal,
                    'predicted_sales' => $predictedSales,
                    'actual_sales'    => $actualSales,
                    'error'           => abs($predictedSales - $actualSales),
                ];
            })
            ->sortByDesc('tanggal')
            ->take(10)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Kirim Data ke View Dashboard
        |--------------------------------------------------------------------------
        | Semua data hasil olahan controller dikirim ke dashboard.blade.php
        | untuk ditampilkan dalam bentuk kartu, tabel, dan grafik.
        |--------------------------------------------------------------------------
        */

        return view('dashboard', [
            'prediction'           => $predictedValue,
            'mae'                  => $mae,
            'rmse'                 => $rmse,
            'validationMae'        => $validationMae,
            'validationRmse'       => $validationRmse,
            'predictionReady'      => $predictionReady,

            'totalData'            => $totalData,
            'periodeDataset'       => $periodeDataset,
            'nextDate'             => $nextDate,
            'nextMonthLabel'       => $nextMonthLabel,

            'productPredictions'   => $productPredictions,
            'totalProducts'        => $totalProducts,
            'topProducts'          => $topProducts,
            'topBars'              => $topBars,

            'predictionComparison' => $predictionComparison,
        ]);
    }

    public function generate()
    {
        /*
        |--------------------------------------------------------------------------
        | Jalankan Script Python Machine Learning
        |--------------------------------------------------------------------------
        | Laravel menjalankan machine_learning/prediction.py.
        | Script Python membaca data dari MongoDB, menjalankan model ML,
        | lalu mengembalikan hasil prediksi dalam format JSON.
        |--------------------------------------------------------------------------
        */

        $script = base_path('machine_learning/prediction.py');
        $command = 'python ' . escapeshellarg($script);
        $output = shell_exec($command);
        $data = json_decode($output, true);

        /*
        |--------------------------------------------------------------------------
        | Validasi Output Python
        |--------------------------------------------------------------------------
        | Jika output Python kosong atau bukan array, proses generate dihentikan.
        |--------------------------------------------------------------------------
        */

        if (!is_array($data) || count($data) === 0) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Generate prediksi gagal. Output Python tidak valid.');
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Tanggal Terakhir Dataset
        |--------------------------------------------------------------------------
        | Tanggal terakhir dari collection penjualans dipakai untuk menentukan
        | periode prediksi berikutnya.
        |--------------------------------------------------------------------------
        */

        $last = DB::connection('mongodb')
            ->table('penjualans')
            ->orderByDesc('tanggal')
            ->first();

        if (!$last) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Dataset penjualan belum tersedia.');
        }

        /*
        |--------------------------------------------------------------------------
        | Tentukan Tanggal Prediksi Berikutnya
        |--------------------------------------------------------------------------
        | Jika tanggal terakhir dataset adalah 2023-12-31,
        | maka hasil prediksi disimpan untuk 2024-01-31.
        |--------------------------------------------------------------------------
        */

        $nextDate = Carbon::parse($last->tanggal)
            ->addMonth()
            ->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Simpan Hasil Prediksi ke MongoDB
        |--------------------------------------------------------------------------
        | Setiap produk disimpan ke collection prediction_results.
        | updateOrInsert digunakan agar data pada tanggal dan product_id yang sama
        | tidak terduplikasi, tetapi diperbarui.
        |--------------------------------------------------------------------------
        */

        foreach ($data as $item) {
            $productId = $item['product_id'] ?? null;

            if (!$productId) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Hitung Aktual Sales
            |--------------------------------------------------------------------------
            | Jika ada data aktual pada tanggal prediksi, nilainya akan dihitung.
            | Jika belum ada, nilainya menjadi 0.
            |--------------------------------------------------------------------------
            */

            $actualSales = DB::connection('mongodb')
                ->table('penjualans')
                ->where('tanggal', $nextDate)
                ->where('product_id', $productId)
                ->sum('jumlah');

            DB::connection('mongodb')
                ->table('prediction_results')
                ->updateOrInsert(
                    [
                        'tanggal'    => $nextDate,
                        'product_id' => $productId,
                    ],
                    [
                        'predicted_sales' => $item['prediction'] ?? 0,
                        'actual_sales'    => $actualSales,
                        'mae'             => $item['mae'] ?? null,
                        'rmse'            => $item['rmse'] ?? null,
                        'validation_mae'  => $item['validation_mae'] ?? null,
                        'validation_rmse' => $item['validation_rmse'] ?? null,
                        'updated_at'      => now(),
                    ]
                );
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Prediksi berhasil digenerate dan disimpan ke MongoDB.');
    }

    private function getProductNames()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Nama Produk dari MongoDB
        |--------------------------------------------------------------------------
        | Collection products digunakan untuk membuat mapping:
        | product_id atau id => nama_bunga.
        |
        | Dibuat fleksibel karena sebagian data bisa memakai field id,
        | sedangkan data lain bisa memakai field product_id.
        |--------------------------------------------------------------------------
        */

        $products = DB::connection('mongodb')
            ->table('products')
            ->get();

        $names = [];

        foreach ($products as $product) {
            $name = $product->nama_bunga
                ?? $product->name
                ?? $product->nama
                ?? null;

            if (!$name) {
                continue;
            }

            if (isset($product->id)) {
                $names[$product->id] = $name;
            }

            if (isset($product->product_id)) {
                $names[$product->product_id] = $name;
            }
        }

        return $names;
    }
}