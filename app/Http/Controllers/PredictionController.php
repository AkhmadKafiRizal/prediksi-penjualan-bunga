<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        | Siapkan Fitur Tanggal untuk Flask
        |--------------------------------------------------------------------------
        | Model Flask membutuhkan fitur weekday dan month.
        | dayOfWeekIso menghasilkan Senin = 1 sampai Minggu = 7.
        | Karena model Python/pandas memakai Senin = 0 sampai Minggu = 6,
        | maka nilainya dikurangi 1.
        |--------------------------------------------------------------------------
        */

        $nextDateCarbon = Carbon::parse($nextDate);
        $weekday = $nextDateCarbon->dayOfWeekIso - 1;
        $month = $nextDateCarbon->month;

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Penjualan Terbaru Per Produk
        |--------------------------------------------------------------------------
        | Data terbaru per product_id dipakai untuk mengambil nilai harga dan promo
        | terakhir. Nilai ini dikirim ke Flask sebagai fitur prediksi.
        |--------------------------------------------------------------------------
        */

        $salesRows = DB::connection('mongodb')
            ->table('penjualans')
            ->orderBy('product_id')
            ->orderByDesc('tanggal')
            ->get();

        $latestSalesPerProduct = $salesRows
            ->groupBy('product_id')
            ->map(function ($rows) {
                return $rows->first();
            })
            ->values();

        if ($latestSalesPerProduct->count() === 0) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Data penjualan per produk tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Endpoint Flask PythonAnywhere
        |--------------------------------------------------------------------------
        | Laravel tidak lagi menjalankan machine_learning/prediction.py lokal.
        | Mulai bagian ini, Laravel memanggil Flask API online yang sudah deploy
        | di PythonAnywhere.
        |--------------------------------------------------------------------------
        */

        $flaskPredictUrl = 'https://kafi.pythonanywhere.com/api/predict';

        $successCount = 0;
        $failedProducts = [];

        /*
        |--------------------------------------------------------------------------
        | Panggil Flask dan Simpan Hasil ke MongoDB
        |--------------------------------------------------------------------------
        | Setiap produk dikirim ke Flask menggunakan product_id, harga, promo,
        | weekday, dan month. Hasil predicted_sales dari Flask tetap disimpan
        | ke collection prediction_results.
        |--------------------------------------------------------------------------
        */

        foreach ($latestSalesPerProduct as $row) {
            $productId = $row->product_id ?? null;
            $harga = $row->harga ?? null;
            $promo = $row->promo ?? 0;

            if (!$productId || $harga === null) {
                $failedProducts[] = $productId ?? 'product_id_tidak_valid';
                continue;
            }

            try {
                $response = Http::timeout(30)->post($flaskPredictUrl, [
                    'product_id' => (int) $productId,
                    'harga'      => (float) $harga,
                    'promo'      => (int) $promo,
                    'weekday'    => (int) $weekday,
                    'month'      => (int) $month,
                ]);
            } catch (\Throwable $e) {
                $failedProducts[] = $productId;
                continue;
            }

            if (!$response->successful()) {
                $failedProducts[] = $productId;
                continue;
            }

            $result = $response->json();

            /*
            |--------------------------------------------------------------------------
            | Ambil Nilai Prediksi dari Response Flask
            |--------------------------------------------------------------------------
            | Flask utama mengembalikan field predicted_sales.
            | Field prediction disiapkan sebagai fallback agar aman jika format
            | response berubah kecil.
            |--------------------------------------------------------------------------
            */

            $predictedSales = $result['predicted_sales']
                ?? $result['prediction']
                ?? null;

            if ($predictedSales === null) {
                $failedProducts[] = $productId;
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

            /*
            |--------------------------------------------------------------------------
            | Ambil Data Prediksi Lama Jika Ada
            |--------------------------------------------------------------------------
            | Flask predict hanya mengembalikan hasil prediksi.
            | Jika data MAE/RMSE sudah pernah tersimpan, nilainya dipertahankan
            | agar dashboard tidak kehilangan data evaluasi lama.
            |--------------------------------------------------------------------------
            */

            $existingPrediction = DB::connection('mongodb')
                ->table('prediction_results')
                ->where('tanggal', $nextDate)
                ->where('product_id', $productId)
                ->first();

            DB::connection('mongodb')
                ->table('prediction_results')
                ->updateOrInsert(
                    [
                        'tanggal'    => $nextDate,
                        'product_id' => $productId,
                    ],
                    [
                        'predicted_sales' => max(0, round((float) $predictedSales)),
                        'actual_sales'    => $actualSales,
                        'mae'             => $result['mae'] ?? ($existingPrediction->mae ?? null),
                        'rmse'            => $result['rmse'] ?? ($existingPrediction->rmse ?? null),
                        'validation_mae'  => $result['validation_mae'] ?? ($existingPrediction->validation_mae ?? null),
                        'validation_rmse' => $result['validation_rmse'] ?? ($existingPrediction->validation_rmse ?? null),
                        'updated_at'      => now(),
                    ]
                );

            $successCount++;
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Hasil Generate
        |--------------------------------------------------------------------------
        | Jika tidak ada satu pun produk yang berhasil diprediksi, tampilkan error.
        | Jika sebagian berhasil, tampilkan warning ringan.
        |--------------------------------------------------------------------------
        */

        if ($successCount === 0) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Generate prediksi gagal. Laravel tidak berhasil mengambil hasil prediksi dari Flask.');
        }

        if (count($failedProducts) > 0) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Prediksi berhasil digenerate sebagian. Berhasil: ' . $successCount . ' produk. Gagal: ' . count($failedProducts) . ' produk.');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Prediksi berhasil digenerate dari Flask PythonAnywhere dan disimpan ke MongoDB.');
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