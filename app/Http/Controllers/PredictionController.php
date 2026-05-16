<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    // =========================================================
    // DASHBOARD
    // =========================================================
    public function dashboard()
    {
        $data = $this->getPredictionData();

        return view('dashboard', $data);
    }

    // =========================================================
    // HALAMAN PREDIKSI
    // =========================================================
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Periode Prediksi
        |--------------------------------------------------------------------------
        | Jika user memilih periode dari query string, gunakan periode tersebut.
        | Jika tidak, periode default dihitung dari tanggal terakhir dataset
        | penjualans + 1 bulan.
        |--------------------------------------------------------------------------
        */
        $selectedPeriod = $request->get('periode', $this->getDefaultPredictionPeriod());

        $data = $this->getPredictionData($selectedPeriod);

        return view('prediksi', $data);
    }

    // =========================================================
    // GENERATE PREDIKSI
    // =========================================================
    public function generate(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Periode dari Query String
        |--------------------------------------------------------------------------
        | Periode dikirim dari blade via ?periode=YYYY-MM.
        | Jika tidak ada, gunakan periode setelah tanggal terakhir dataset.
        |--------------------------------------------------------------------------
        */
        $selectedPeriod = $request->get('periode', $this->getDefaultPredictionPeriod());

        /*
        |--------------------------------------------------------------------------
        | Bentuk Tanggal Prediksi
        |--------------------------------------------------------------------------
        | Hasil prediksi bulanan disimpan sebagai tanggal akhir bulan.
        | Contoh:
        | - periode 2024-01 disimpan sebagai 2024-01-31
        | - periode 2024-02 disimpan sebagai 2024-02-29
        |--------------------------------------------------------------------------
        */
        $nextDate = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->endOfMonth()
            ->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Cek apakah prediksi periode ini sudah ada
        |--------------------------------------------------------------------------
        | Dipakai untuk membedakan pesan sukses: "digenerate" vs "diperbarui".
        |--------------------------------------------------------------------------
        */
        $alreadyExists = DB::connection('mongodb')
            ->table('prediction_results')
            ->where('tanggal', $nextDate)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | Siapkan Fitur Tanggal untuk Flask
        |--------------------------------------------------------------------------
        | Model Flask membutuhkan fitur weekday dan month.
        | weekday dibuat sesuai pola Python/pandas:
        | Senin = 0, Selasa = 1, ..., Minggu = 6.
        |--------------------------------------------------------------------------
        */
        $nextDateCarbon = Carbon::parse($nextDate);
        $weekday = $nextDateCarbon->dayOfWeekIso - 1;
        $month = $nextDateCarbon->month;

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Penjualan Terbaru Per Produk
        |--------------------------------------------------------------------------
        | Laravel mengambil data terakhir setiap product_id dari MongoDB.
        | Nilai harga dan promo terakhir dipakai sebagai fitur input ke Flask.
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
                ->route('prediksi', ['periode' => $selectedPeriod])
                ->with('error', 'Data penjualan per produk tidak ditemukan.');
        }

        /*
        |--------------------------------------------------------------------------
        | Endpoint Flask PythonAnywhere
        |--------------------------------------------------------------------------
        | Laravel tidak lagi menjalankan machine_learning/prediction.py lokal.
        | Generate prediksi sekarang memanggil Flask API online yang sudah deploy
        | di PythonAnywhere.
        |--------------------------------------------------------------------------
        */
        $flaskPredictUrl = 'https://kafi.pythonanywhere.com/api/predict';

        /*
        |--------------------------------------------------------------------------
        | Panggil Flask dan Simpan Hasil Prediksi ke MongoDB
        |--------------------------------------------------------------------------
        | Setiap produk dikirim ke Flask menggunakan:
        | product_id, harga, promo, weekday, dan month.
        | Hasil predicted_sales disimpan ke collection prediction_results.
        |--------------------------------------------------------------------------
        */
        $successCount   = 0;
        $failedProducts = [];

        foreach ($latestSalesPerProduct as $row) {
            $productId = $row->product_id ?? null;
            $harga     = $row->harga ?? null;
            $promo     = $row->promo ?? 0;

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
            | Field prediction disediakan sebagai fallback jika format response
            | berubah kecil.
            |--------------------------------------------------------------------------
            */
            $predictedSales = $result['predicted_sales']
                ?? $result['prediction']
                ?? null;

            if ($predictedSales === null) {
                $failedProducts[] = $productId;
                continue;
            }

            try {
                /*
                |--------------------------------------------------------------
                | Hitung Aktual Sales
                |--------------------------------------------------------------
                | Jika ada data aktual pada tanggal prediksi, nilainya dihitung.
                | Jika belum ada, nilainya 0.
                |--------------------------------------------------------------
                */
                $actualSales = DB::connection('mongodb')
                    ->table('penjualans')
                    ->where('tanggal', $nextDate)
                    ->where('product_id', $productId)
                    ->sum('jumlah');

                /*
                |--------------------------------------------------------------
                | Ambil Data Prediksi Lama Jika Ada
                |--------------------------------------------------------------
                | Flask predict hanya mengembalikan hasil prediksi.
                | Jika data MAE/RMSE sudah pernah tersimpan, nilainya
                | dipertahankan agar dashboard tidak kehilangan data evaluasi.
                |--------------------------------------------------------------
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
                            'mae'             => $result['mae']             ?? ($existingPrediction->mae             ?? null),
                            'rmse'            => $result['rmse']            ?? ($existingPrediction->rmse            ?? null),
                            'validation_mae'  => $result['validation_mae']  ?? ($existingPrediction->validation_mae  ?? null),
                            'validation_rmse' => $result['validation_rmse'] ?? ($existingPrediction->validation_rmse ?? null),
                            'updated_at'      => now(),
                        ]
                    );

                $successCount++;

            } catch (\Throwable $e) {
                $failedProducts[] = $productId;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect dengan Pesan
        |--------------------------------------------------------------------------
        */
        $redirectParams = ['periode' => $selectedPeriod];

        if ($successCount === 0) {
            return redirect()
                ->route('prediksi', $redirectParams)
                ->with('error', 'Generate prediksi gagal. Laravel tidak berhasil mengambil hasil prediksi dari Flask.');
        }

        if (count($failedProducts) > 0) {
            return redirect()
                ->route('prediksi', $redirectParams)
                ->with('success', "Prediksi {$selectedPeriod} berhasil sebagian. Berhasil: {$successCount} produk, Gagal: " . count($failedProducts) . " produk.");
        }

        // Pesan berbeda: generate baru vs generate ulang.
        $label = $alreadyExists ? 'diperbarui' : 'digenerate';

        return redirect()
            ->route('prediksi', $redirectParams)
            ->with('success', "Prediksi {$selectedPeriod} berhasil {$label} dari Flask PythonAnywhere dan disimpan ke MongoDB.");
    }

    // =========================================================
    // EXPORT
    // =========================================================
    public function export()
    {
        return "Export prediksi berhasil"; // kembangkan sesuai kebutuhan
    }

    // =========================================================
    // PRIVATE — Ambil Data Prediksi berdasarkan Periode
    // =========================================================
    private function getPredictionData(string $selectedPeriod = null)
    {
        /*
        |--------------------------------------------------------------------------
        | Default Periode Prediksi
        |--------------------------------------------------------------------------
        | Default tidak memakai tanggal hari ini, tetapi memakai tanggal terakhir
        | dataset penjualans + 1 bulan agar selaras dengan alur prediksi ML.
        |--------------------------------------------------------------------------
        */
        if (!$selectedPeriod) {
            $selectedPeriod = $this->getDefaultPredictionPeriod();
        }

        $productNames = $this->getProductNames();

        /*
        |--------------------------------------------------------------------------
        | Ambil prediksi berdasarkan periode yang dipilih
        |--------------------------------------------------------------------------
        | Data prediction_results disimpan sebagai tanggal akhir bulan.
        | Contoh periode 2024-01 dicari sebagai tanggal 2024-01-31.
        |--------------------------------------------------------------------------
        */
        $targetDate = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->endOfMonth()
            ->format('Y-m-d');

        $savedPredictions = DB::connection('mongodb')
            ->table('prediction_results')
            ->where('tanggal', $targetDate)
            ->orderBy('product_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Waktu Terakhir Generate
        |--------------------------------------------------------------------------
        */
        $lastRunAt = null;

        if ($savedPredictions->count() > 0) {
            $latest = $savedPredictions->sortByDesc('updated_at')->first();

            $lastRunAt = $latest->updated_at
                ? Carbon::parse($latest->updated_at)->format('d M Y, H:i')
                : null;
        }

        /*
        |--------------------------------------------------------------------------
        | Map Data Prediksi
        |--------------------------------------------------------------------------
        */
        $productPredictions = $savedPredictions->map(function ($item) use ($productNames) {
            $productId = $item->product_id ?? null;

            return [
                'product_id'      => $productId,
                'product_name'    => $productNames[$productId] ?? ('Produk #' . $productId),
                'prediction'      => $item->predicted_sales ?? 0,
                'mae'             => $item->mae ?? 0,
                'rmse'            => $item->rmse ?? 0,
                'validation_mae'  => $item->validation_mae ?? 0,
                'validation_rmse' => $item->validation_rmse ?? 0,
            ];
        })->values();

        $predictionReady = $productPredictions->count() > 0;
        $predictedValue  = $productPredictions->sum('prediction');
        $totalProducts   = $productPredictions->count();

        $mae            = $predictionReady ? round($productPredictions->avg('mae'), 2) : 0;
        $rmse           = $predictionReady ? round($productPredictions->avg('rmse'), 2) : 0;
        $validationMae  = $predictionReady ? round($productPredictions->avg('validation_mae'), 2) : 0;
        $validationRmse = $predictionReady ? round($productPredictions->avg('validation_rmse'), 2) : 0;

        $topProducts = $productPredictions->sortByDesc('prediction')->take(5)->values();
        $topBars     = $productPredictions->sortByDesc('prediction')->take(10)->values();

        $totalData = DB::connection('mongodb')->table('penjualans')->count();

        /*
        |--------------------------------------------------------------------------
        | Label Bulan dari Periode yang Dipilih
        |--------------------------------------------------------------------------
        */
        Carbon::setLocale('id');

        $nextMonthLabel = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->translatedFormat('F Y');

        /*
        |--------------------------------------------------------------------------
        | Prediksi vs Real — Semua Periode
        |--------------------------------------------------------------------------
        | Mengelompokkan data prediction_results berdasarkan tanggal.
        |--------------------------------------------------------------------------
        */
        $predictionComparison = DB::connection('mongodb')
            ->table('prediction_results')
            ->get()
            ->groupBy('tanggal')
            ->map(function ($rows, $tanggal) {
                $predictedSales = $rows->sum(fn($r) => $r->predicted_sales ?? 0);
                $actualSales    = $rows->sum(fn($r) => $r->actual_sales ?? 0);

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

        return [
            'prediction'           => $predictedValue,
            'mae'                  => $mae,
            'rmse'                 => $rmse,
            'validationMae'        => $validationMae,
            'validationRmse'       => $validationRmse,
            'predictionReady'      => $predictionReady,
            'totalData'            => $totalData,
            'nextMonthLabel'       => $nextMonthLabel,
            'selectedPeriod'       => $selectedPeriod,    // untuk tombol generate
            'lastRunAt'            => $lastRunAt,          // untuk status terakhir update
            'productPredictions'   => $productPredictions,
            'totalProducts'        => $totalProducts,
            'topProducts'          => $topProducts,
            'topBars'              => $topBars,
            'predictionComparison' => $predictionComparison,
        ];
    }

    // =========================================================
    // HELPER — Ambil Periode Default dari Tanggal Terakhir Dataset
    // =========================================================
    private function getDefaultPredictionPeriod()
    {
        /*
        |--------------------------------------------------------------------------
        | Periode Default Berdasarkan Dataset
        |--------------------------------------------------------------------------
        | Sistem prediksi mengikuti tanggal terakhir di collection penjualans.
        | Jika data terakhir 2023-12-31, maka periode default adalah 2024-01.
        |--------------------------------------------------------------------------
        */
        $last = DB::connection('mongodb')
            ->table('penjualans')
            ->orderByDesc('tanggal')
            ->first();

        if (!$last || empty($last->tanggal)) {
            return now()->addMonth()->format('Y-m');
        }

        return Carbon::parse($last->tanggal)
            ->addMonth()
            ->format('Y-m');
    }

    // =========================================================
    // HELPER — Ambil Nama Produk dari Collection products
    // =========================================================
    private function getProductNames()
    {
        $products = DB::connection('mongodb')->table('products')->get();
        $names    = [];

        foreach ($products as $product) {
            $name = $product->nama_bunga ?? $product->name ?? $product->nama ?? null;

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