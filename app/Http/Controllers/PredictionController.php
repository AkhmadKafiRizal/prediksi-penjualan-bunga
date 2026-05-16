<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Ambil periode dari query string, default = bulan depan
        $selectedPeriod = $request->get('periode', now()->addMonth()->format('Y-m'));

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
        | Periode dikirim dari blade via ?periode=YYYY-MM
        | Default: bulan depan
        |--------------------------------------------------------------------------
        */
        $selectedPeriod = $request->get('periode', now()->addMonth()->format('Y-m'));

        // Bentuk tanggal lengkap dari periode (hari pertama bulan)
        $nextDate = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->startOfMonth()
            ->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Cek apakah prediksi periode ini sudah ada
        |--------------------------------------------------------------------------
        | Dipakai untuk membedakan pesan sukses: "digenerate" vs "diperbarui"
        |--------------------------------------------------------------------------
        */
        $alreadyExists = DB::connection('mongodb')
            ->table('prediction_results')
            ->where('tanggal', $nextDate)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | Jalankan Script Python Machine Learning
        |--------------------------------------------------------------------------
        | Script Python membaca data dari MongoDB, menjalankan model ML,
        | lalu mengembalikan hasil prediksi dalam format JSON.
        |--------------------------------------------------------------------------
        */
        $script  = base_path('machine_learning/prediction.py');
        $command = 'python ' . escapeshellarg($script);
        $output  = shell_exec($command);
        $data    = json_decode($output, true);

        /*
        |--------------------------------------------------------------------------
        | Validasi Output Python
        |--------------------------------------------------------------------------
        */
        if (!is_array($data) || count($data) === 0) {
            return redirect()
                ->route('prediksi', ['periode' => $selectedPeriod])
                ->with('error', 'Generate prediksi gagal. Output Python tidak valid.');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Hasil Prediksi ke MongoDB
        |--------------------------------------------------------------------------
        */
        $successCount   = 0;
        $failedProducts = [];

        foreach ($data as $item) {
            $productId      = $item['product_id'] ?? null;
            $predictedSales = $item['predicted_sales'] ?? $item['prediction'] ?? 0;

            if (!$productId) {
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
                | Agar MAE/RMSE lama tidak hilang jika Python tidak mengirimnya.
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
                            'mae'             => $item['mae']             ?? ($existingPrediction->mae             ?? null),
                            'rmse'            => $item['rmse']            ?? ($existingPrediction->rmse            ?? null),
                            'validation_mae'  => $item['validation_mae']  ?? ($existingPrediction->validation_mae  ?? null),
                            'validation_rmse' => $item['validation_rmse'] ?? ($existingPrediction->validation_rmse ?? null),
                            'updated_at'      => now(),
                        ]
                    );

                $successCount++;

            } catch (\Exception $e) {
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
                ->with('error', 'Generate prediksi gagal. Tidak ada produk yang berhasil diprediksi.');
        }

        if (count($failedProducts) > 0) {
            return redirect()
                ->route('prediksi', $redirectParams)
                ->with('success', "Prediksi {$selectedPeriod} berhasil sebagian. Berhasil: {$successCount} produk, Gagal: " . count($failedProducts) . " produk.");
        }

        // Pesan berbeda: generate baru vs generate ulang
        $label = $alreadyExists ? 'diperbarui' : 'digenerate';

        return redirect()
            ->route('prediksi', $redirectParams)
            ->with('success', "Prediksi {$selectedPeriod} berhasil {$label} dan disimpan ke MongoDB.");
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
        // Default: bulan depan
        if (!$selectedPeriod) {
            $selectedPeriod = now()->addMonth()->format('Y-m');
        }

        $productNames = $this->getProductNames();

        /*
        |--------------------------------------------------------------------------
        | Ambil prediksi berdasarkan periode yang dipilih
        |--------------------------------------------------------------------------
        | Tanggal disimpan sebagai 'Y-m-d', kita filter by tanggal exact
        | (hari pertama bulan = startOfMonth)
        |--------------------------------------------------------------------------
        */
        $targetDate = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->startOfMonth()
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
            $latest    = $savedPredictions->sortByDesc('updated_at')->first();
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
        | Prediksi vs Real — Semua Periode (untuk tabel perbandingan)
        |--------------------------------------------------------------------------
        */
        $predictionComparison = DB::connection('mongodb')
            ->table('prediction_results')
            ->get()
            ->groupBy('tanggal')
            ->map(function ($rows, $tanggal) {
                return (object) [
                    'tanggal'         => $tanggal,
                    'predicted_sales' => $rows->sum(fn($r) => $r->predicted_sales ?? 0),
                    'actual_sales'    => $rows->sum(fn($r) => $r->actual_sales ?? 0),
                    'error'           => abs(
                        $rows->sum(fn($r) => $r->predicted_sales ?? 0) -
                        $rows->sum(fn($r) => $r->actual_sales ?? 0)
                    ),
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
            'selectedPeriod'       => $selectedPeriod,    // ← untuk tombol generate
            'lastRunAt'            => $lastRunAt,          // ← untuk status terakhir update
            'productPredictions'   => $productPredictions,
            'totalProducts'        => $totalProducts,
            'topProducts'          => $topProducts,
            'topBars'              => $topBars,
            'predictionComparison' => $predictionComparison,
        ];
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
            if (!$name) continue;
            if (isset($product->id))         $names[$product->id]         = $name;
            if (isset($product->product_id)) $names[$product->product_id] = $name;
        }

        return $names;
    }
}