<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $periodStart = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->startOfMonth()
            ->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Cek apakah prediksi periode ini sudah ada
        |--------------------------------------------------------------------------
        | Dipakai untuk membedakan pesan sukses: "digenerate" vs "diperbarui".
        |--------------------------------------------------------------------------
        */
        try {
            $alreadyExists = DB::connection('mongodb')
                ->table('prediction_results')
                ->where('tanggal', $nextDate)
                ->exists();
        } catch (\Throwable $e) {
            return redirect()
                ->route('prediksi', ['periode' => $selectedPeriod])
                ->with('error', 'Generate prediksi belum bisa dimulai karena koneksi MongoDB sedang timeout saat mengecek data prediksi yang sudah ada.');
        }

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
        | Laravel mengambil 1 data terakhir setiap product_id dari MongoDB.
        | Data dibatasi sebelum periode prediksi agar generate Januari 2024
        | tidak memakai transaksi mobile yang lebih baru, misalnya tahun 2026.
        | Query dilakukan via aggregation agar tidak menarik 91 ribu row ke PHP.
        |--------------------------------------------------------------------------
        */
        try {
            $latestSalesPerProduct = $this->getLatestSalesPerProductBefore($periodStart);
            $activeProductIds = $this->getActiveProductIds();
            $latestSalesPerProduct = $latestSalesPerProduct
                ->filter(fn ($row) => in_array((int) ($row->product_id ?? 0), $activeProductIds, true))
                ->values();
        } catch (\Throwable $e) {
            return redirect()
                ->route('prediksi', ['periode' => $selectedPeriod])
                ->with('error', 'Generate prediksi belum berhasil karena koneksi MongoDB sedang timeout saat membaca data penjualan terbaru per produk. Coba ulangi beberapa saat lagi.');
        }

        if ($latestSalesPerProduct->count() === 0) {
            return redirect()
                ->route('prediksi', ['periode' => $selectedPeriod])
                ->with('error', "Data penjualan produk aktif sebelum periode {$selectedPeriod} tidak ditemukan.");
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

    private function getLatestSalesPerProductBefore(string $periodStart)
    {
        $cursor = DB::connection('mongodb')->getCollection('penjualans')->aggregate([
            [
                '$match' => [
                    'product_id' => ['$exists' => true, '$ne' => null],
                    'harga' => ['$exists' => true, '$ne' => null],
                    'tanggal' => [
                        '$type' => 'string',
                        '$lt' => $periodStart,
                    ],
                ],
            ],
            [
                '$sort' => [
                    'product_id' => 1,
                    'tanggal' => -1,
                    'created_at' => -1,
                    '_id' => -1,
                ],
            ],
            [
                '$group' => [
                    '_id' => '$product_id',
                    'row' => ['$first' => '$$ROOT'],
                ],
            ],
            ['$replaceRoot' => ['newRoot' => '$row']],
            [
                '$project' => [
                    '_id' => 0,
                    'product_id' => 1,
                    'harga' => 1,
                    'promo' => 1,
                    'tanggal' => 1,
                ],
            ],
        ], [
            'allowDiskUse' => true,
            'maxTimeMS' => 30000,
        ]);

        return collect(iterator_to_array($cursor, false))
            ->filter(fn ($row) => isset($row->product_id, $row->harga))
            ->values();
    }

    // =========================================================
    // EXPORT
    // =========================================================
    public function export(Request $request)
    {
        $selectedPeriod = $request->get('periode', $this->getDefaultPredictionPeriod());
        $targetDate = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->endOfMonth()
            ->format('Y-m-d');

        $rows = DB::connection('mongodb')
            ->table('prediction_results')
            ->where('tanggal', $targetDate)
            ->orderByDesc('predicted_sales')
            ->orderBy('product_id')
            ->get();

        $activeProductIds = $this->getActiveProductIds();
        $rows = $rows
            ->filter(fn ($row) => in_array((int) ($row->product_id ?? 0), $activeProductIds, true))
            ->values();

        if ($rows->isEmpty()) {
            return redirect()
                ->route('prediksi', ['periode' => $selectedPeriod])
                ->with('error', "Data prediksi produk aktif periode {$selectedPeriod} belum tersedia untuk diexport.");
        }

        $productNames = $this->getProductNames();
        $periodLabel = Carbon::createFromFormat('Y-m', $selectedPeriod)
            ->translatedFormat('F Y');

        $validationMetricSource = $this->getLatestProductValidationMetrics($targetDate);
        $validationFallbacks = $validationMetricSource['items'] ?? collect();

        $exportRows = $rows->values()->map(function ($row, $index) use ($productNames, $selectedPeriod, $targetDate, $validationFallbacks) {
            $productId = $row->product_id ?? null;
            $prediction = (float) ($row->predicted_sales ?? 0);
            $fallback = $validationFallbacks->get((string) $productId, []);
            $mae = $row->mae ?? ($fallback['mae'] ?? null);
            $rmse = $row->rmse ?? ($fallback['rmse'] ?? null);
            $accuracy = $fallback['accuracy'] ?? null;
            $accuracy = $accuracy ?? ($prediction > 0 && $mae !== null
                ? max(0, min(100, 100 - (($mae / $prediction) * 100)))
                : null);

            return [
                'no' => $index + 1,
                'periode' => $selectedPeriod,
                'tanggal_prediksi' => $targetDate,
                'product_id' => $productId,
                'nama_bunga' => $productNames[$productId] ?? $productNames[(string) $productId] ?? ('Produk #' . $productId),
                'estimasi_kebutuhan_tangkai' => round($prediction),
                'mae' => $mae,
                'rmse' => $rmse,
                'akurasi_persen' => $accuracy !== null ? round($accuracy, 2) : null,
                'validation_mae' => $row->validation_mae ?? ($fallback['validation_mae'] ?? null),
                'validation_rmse' => $row->validation_rmse ?? ($fallback['validation_rmse'] ?? null),
                'updated_at' => isset($row->updated_at) ? (string) $row->updated_at : null,
            ];
        });

        $filename = "laporan-prediksi-kebutuhan-{$selectedPeriod}.xlsx";
        $filePath = $this->createPredictionWorkbook($exportRows, [
            'period_label' => $periodLabel,
            'selected_period' => $selectedPeriod,
            'target_date' => $targetDate,
            'total_products' => $exportRows->count(),
            'total_prediction' => $exportRows->sum('estimasi_kebutuhan_tangkai'),
            'exported_at' => now()->format('d M Y, H:i') . ' WIB',
        ]);

        return response()
            ->download($filePath, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend(true);
    }

    private function createPredictionWorkbook(Collection $rows, array $meta): string
    {
        $path = tempnam(storage_path('app'), 'prediksi-');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('FloraPredict')
            ->setLastModifiedBy('FloraPredict')
            ->setTitle('FloraPredict - Laporan Estimasi Kebutuhan Bunga')
            ->setSubject('Laporan estimasi kebutuhan bunga')
            ->setDescription('Hasil prediksi kebutuhan stok bunga berdasarkan model aktif FloraPredict.');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Estimasi Kebutuhan');

        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A1', 'FloraPredict - Laporan Estimasi Kebutuhan Bunga');
        $sheet->setCellValue('A2', 'Hasil prediksi kebutuhan stok bunga berdasarkan model aktif FloraPredict.');

        $sheet->setCellValue('A4', 'Periode Prediksi');
        $sheet->setCellValue('B4', $meta['period_label']);
        $sheet->setCellValue('C4', 'Tanggal Prediksi');
        $sheet->setCellValue('D4', $meta['target_date']);
        $sheet->setCellValue('E4', 'Total Produk');
        $sheet->setCellValue('F4', $meta['total_products']);
        $sheet->setCellValue('G4', 'Total Estimasi');
        $sheet->setCellValue('H4', $meta['total_prediction']);
        $sheet->setCellValue('I4', 'Diexport Pada');
        $sheet->setCellValue('J4', $meta['exported_at']);

        $headers = [
            'No',
            'Periode',
            'Tanggal Prediksi',
            'Product ID',
            'Nama Bunga',
            'Estimasi Kebutuhan',
            'MAE Validasi',
            'RMSE Validasi',
            'Akurasi Validasi (%)',
            'MAE Validasi Internal',
            'RMSE Validasi Internal',
        ];

        $sheet->fromArray($headers, null, 'A6');

        $rowNumber = 7;
        foreach ($rows as $row) {
            $sheet->setCellValue("A{$rowNumber}", $row['no']);
            $sheet->setCellValueExplicit("B{$rowNumber}", (string) $row['periode'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$rowNumber}", (string) $row['tanggal_prediksi'], DataType::TYPE_STRING);
            $sheet->setCellValue("D{$rowNumber}", $row['product_id']);
            $sheet->setCellValueExplicit("E{$rowNumber}", (string) $row['nama_bunga'], DataType::TYPE_STRING);
            $sheet->setCellValue("F{$rowNumber}", $row['estimasi_kebutuhan_tangkai']);
            $sheet->setCellValue("G{$rowNumber}", $row['mae']);
            $sheet->setCellValue("H{$rowNumber}", $row['rmse']);
            $sheet->setCellValue("I{$rowNumber}", $row['akurasi_persen']);
            $sheet->setCellValue("J{$rowNumber}", $row['validation_mae']);
            $sheet->setCellValue("K{$rowNumber}", $row['validation_rmse']);
            $rowNumber++;
        }

        $lastDataRow = max(6, $rowNumber - 1);
        $noteRow = $lastDataRow + 2;

        $sheet->mergeCells("A{$noteRow}:K{$noteRow}");
        $sheet->setCellValue("A{$noteRow}", 'Catatan: Generate prediksi menggunakan model aktif. Dataset historis digunakan pada tahap pelatihan dan evaluasi model.');

        $labelStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => '7A4060']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF2F8']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'F6C9DA']]],
        ];

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18)->getColor()->setRGB('E8185A');
        $sheet->getStyle('A2')->getFont()->setSize(11)->getColor()->setRGB('7A4060');

        foreach (['A4', 'C4', 'E4', 'G4', 'I4'] as $cell) {
            $sheet->getStyle($cell)->applyFromArray($labelStyle);
        }

        $sheet->getStyle('B4:J4')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'F6C9DA']]],
        ]);

        $sheet->getStyle('A6:K6')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8185A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C2185B']]],
        ]);

        if ($lastDataRow >= 7) {
            $sheet->getStyle("A7:K{$lastDataRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'F6C9DA']]],
            ]);

            for ($row = 8; $row <= $lastDataRow; $row += 2) {
                $sheet->getStyle("A{$row}:K{$row}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('FFF7FB');
            }

            $sheet->getStyle("F7:F{$lastDataRow}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("G7:K{$lastDataRow}")->getNumberFormat()->setFormatCode('0.00');
        }

        $sheet->getStyle("A{$noteRow}")->getFont()->getColor()->setRGB('7A4060');
        $sheet->getStyle("A{$noteRow}")->getAlignment()->setWrapText(true);

        foreach ([
            'A' => 6,
            'B' => 14,
            'C' => 18,
            'D' => 12,
            'E' => 24,
            'F' => 22,
            'G' => 14,
            'H' => 14,
            'I' => 14,
            'J' => 16,
            'K' => 16,
        ] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->getRowDimension(1)->setRowHeight(28);
        $sheet->getRowDimension(6)->setRowHeight(24);
        $sheet->freezePane('A7');
        $sheet->setAutoFilter("A6:K{$lastDataRow}");

        (new Xlsx($spreadsheet))->save($path);
        $spreadsheet->disconnectWorksheets();

        return $path;
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

        $availablePredictionPeriods = $this->getAvailablePredictionPeriods();
        $nextPredictionPeriod = $this->getNextPredictionPeriod(
            $availablePredictionPeriods,
            $selectedPeriod
        );
        if (
            $availablePredictionPeriods->isNotEmpty()
            && ! $availablePredictionPeriods->contains(fn ($period) => ($period['value'] ?? null) === $selectedPeriod)
            && ($nextPredictionPeriod['value'] ?? null) !== $selectedPeriod
        ) {
            $selectedPeriod = $availablePredictionPeriods->last()['value'];
            $nextPredictionPeriod = $this->getNextPredictionPeriod(
                $availablePredictionPeriods,
                $selectedPeriod
            );
        }

        $productNames = $this->getProductNames();
        $activeProductIds = $this->getActiveProductIds();
        $recentSales = $this->getRecentSales($productNames);

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
            ->orderByDesc('predicted_sales')
            ->orderBy('product_id')
            ->get()
            ->filter(fn ($row) => in_array((int) ($row->product_id ?? 0), $activeProductIds, true))
            ->values();

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
                'mae'             => $item->mae ?? null,
                'rmse'            => $item->rmse ?? null,
                'validation_mae'  => $item->validation_mae ?? null,
                'validation_rmse' => $item->validation_rmse ?? null,
                'accuracy'        => null,
            ];
        })->values();

        $validationMetricSource = $this->getLatestProductValidationMetrics($targetDate);
        $validationFallbacks = $validationMetricSource['items'] ?? collect();

        if ($validationFallbacks->isNotEmpty()) {
            $productPredictions = $productPredictions->map(function ($item) use ($validationFallbacks) {
                $fallback = $validationFallbacks->get((string) ($item['product_id'] ?? ''), []);

                $item['mae'] = $item['mae'] ?? ($fallback['mae'] ?? null);
                $item['rmse'] = $item['rmse'] ?? ($fallback['rmse'] ?? null);
                $item['validation_mae'] = $item['validation_mae'] ?? ($fallback['validation_mae'] ?? null);
                $item['validation_rmse'] = $item['validation_rmse'] ?? ($fallback['validation_rmse'] ?? null);
                $item['accuracy'] = $item['accuracy'] ?? ($fallback['accuracy'] ?? null);

                return $item;
            })->values();
        }

        $predictionReady = $productPredictions->count() > 0;
        $predictedValue  = $productPredictions->sum('prediction');
        $totalProducts   = $productPredictions->count();

        $maeValues = $productPredictions
            ->pluck('mae')
            ->filter(fn ($value) => $value !== null);
        $rmseValues = $productPredictions
            ->pluck('rmse')
            ->filter(fn ($value) => $value !== null);
        $validationMaeValues = $productPredictions
            ->pluck('validation_mae')
            ->filter(fn ($value) => $value !== null);
        $validationRmseValues = $productPredictions
            ->pluck('validation_rmse')
            ->filter(fn ($value) => $value !== null);

        $mae            = $maeValues->isNotEmpty() ? round($maeValues->avg(), 2) : null;
        $rmse           = $rmseValues->isNotEmpty() ? round($rmseValues->avg(), 2) : null;
        $validationMae  = $validationMaeValues->isNotEmpty() ? round($validationMaeValues->avg(), 2) : null;
        $validationRmse = $validationRmseValues->isNotEmpty() ? round($validationRmseValues->avg(), 2) : null;
        $evaluationReady = $mae !== null && $rmse !== null;
        $productAccuracies = $productPredictions
            ->map(function ($item) {
                if (($item['accuracy'] ?? null) !== null) {
                    return (float) $item['accuracy'];
                }

                $prediction = (float) ($item['prediction'] ?? 0);
                $mae        = $item['mae'] ?? null;

                if ($prediction <= 0 || $mae === null) {
                    return null;
                }

                return max(0, min(100, 100 - (($mae / $prediction) * 100)));
            })
            ->reject(fn ($accuracy) => $accuracy === null);

        $modelAccuracy = $productAccuracies->isNotEmpty()
            ? round($productAccuracies->avg(), 2)
            : null;

        $topProducts = $productPredictions->sortByDesc('prediction')->take(5)->values();
        $topBars     = $productPredictions->sortByDesc('prediction')->take(10)->values();
        $monthlySalesTrend = $this->getMonthlySalesTrend();

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
        $predictionRows = DB::connection('mongodb')
            ->table('prediction_results')
            ->get()
            ->filter(fn ($row) => in_array((int) ($row->product_id ?? 0), $activeProductIds, true))
            ->values();

        $predictionDates = $predictionRows
            ->pluck('tanggal')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $actualSalesByDate = collect();

        if (count($predictionDates) > 0) {
            $actualCursor = DB::connection('mongodb')->getCollection('penjualans')->aggregate([
                [
                    '$match' => [
                        'tanggal' => ['$in' => $predictionDates],
                        'product_id' => ['$in' => $activeProductIds],
                    ],
                ],
                [
                    '$group' => [
                        '_id' => '$tanggal',
                        'count' => ['$sum' => 1],
                        'total' => [
                            '$sum' => [
                                '$convert' => [
                                    'input' => '$jumlah',
                                    'to' => 'double',
                                    'onError' => 0,
                                    'onNull' => 0,
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            $actualSalesByDate = collect(iterator_to_array($actualCursor, false))
                ->keyBy(fn ($row) => (string) ($row->_id ?? ''));
        }

        $predictionComparison = $predictionRows
            ->groupBy('tanggal')
            ->map(function ($rows, $tanggal) use ($actualSalesByDate) {
                $predictedSales = $rows->sum(fn($r) => $r->predicted_sales ?? 0);
                $actualRow      = $actualSalesByDate->get((string) $tanggal);
                $hasActualData  = $actualRow && (($actualRow->count ?? 0) > 0);
                $actualSales    = $hasActualData ? (float) ($actualRow->total ?? 0) : null;

                return (object) [
                    'tanggal'         => $tanggal,
                    'predicted_sales' => $predictedSales,
                    'actual_sales'    => $actualSales,
                    'error'           => $hasActualData ? abs($predictedSales - $actualSales) : null,
                    'has_actual'      => $hasActualData,
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
            'modelAccuracy'        => $modelAccuracy,
            'evaluationReady'      => $evaluationReady,
            'predictionReady'      => $predictionReady,
            'totalData'            => $totalData,
            'nextMonthLabel'       => $nextMonthLabel,
            'selectedPeriod'       => $selectedPeriod,    // untuk tombol generate
            'availablePredictionPeriods' => $availablePredictionPeriods,
            'nextPredictionPeriod' => $nextPredictionPeriod,
            'lastRunAt'            => $lastRunAt,          // untuk status terakhir update
            'productPredictions'   => $productPredictions,
            'totalProducts'        => $totalProducts,
            'topProducts'          => $topProducts,
            'topBars'              => $topBars,
            'monthlySalesTrend'    => $monthlySalesTrend,
            'recentSales'          => $recentSales,
            'predictionComparison' => $predictionComparison,
        ];
    }

    private function getRecentSales(array $productNames)
    {
        try {
            return DB::connection('mongodb')
                ->table('penjualans')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('transaction_number', 'desc')
                ->orderBy('product_id', 'asc')
                ->take(10)
                ->get()
                ->map(function ($row) use ($productNames) {
                    $productId = $row->product_id ?? null;

                    return (object) [
                        'tanggal'      => $row->tanggal ?? '-',
                        'product_id'   => $productId,
                        'product_name' => $productNames[$productId] ?? $productNames[(string) $productId] ?? ('Produk #' . $productId),
                        'qty'          => (int) ($row->jumlah ?? 0),
                        'harga'        => (float) ($row->harga ?? 0),
                        'promo'        => (int) ($row->promo ?? 0),
                        'kasir_name'   => $row->kasir_name ?? $row->cashier_name ?? $row->user_name ?? 'Data historis',
                    ];
                });
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function getMonthlySalesTrend()
    {
        try {
            $cursor = DB::connection('mongodb')->getCollection('penjualans')->aggregate([
                [
                    '$match' => [
                        'tanggal' => ['$type' => 'string'],
                        'source' => ['$ne' => 'mobile'],
                    ],
                ],
                [
                    '$project' => [
                        'month' => ['$substr' => ['$tanggal', 0, 7]],
                        'jumlah' => [
                            '$convert' => [
                                'input' => '$jumlah',
                                'to' => 'double',
                                'onError' => 0,
                                'onNull' => 0,
                            ],
                        ],
                    ],
                ],
                ['$match' => ['month' => ['$regex' => '^[0-9]{4}-[0-9]{2}$']]],
                [
                    '$group' => [
                        '_id' => '$month',
                        'total' => ['$sum' => '$jumlah'],
                    ],
                ],
                ['$sort' => ['_id' => 1]],
            ]);

            Carbon::setLocale('id');

            return collect(iterator_to_array($cursor, false))
                ->map(function ($row) {
                    return [
                        'period' => $row->_id,
                        'label' => Carbon::createFromFormat('Y-m', $row->_id)->translatedFormat('M Y'),
                        'total' => (int) round($row->total ?? 0),
                    ];
                })
                ->values();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function getLatestProductValidationMetrics(?string $maxDate = null): array
    {
        try {
            $match = [
                'mae' => ['$ne' => null],
                'rmse' => ['$ne' => null],
            ];

            if ($maxDate !== null) {
                $match['tanggal'] = ['$lte' => $maxDate];
            }

            $cursor = DB::connection('mongodb')->getCollection('prediction_results')->aggregate([
                ['$match' => $match],
                ['$group' => ['_id' => '$tanggal']],
                ['$sort' => ['_id' => -1]],
                ['$limit' => 1],
            ]);

            $latest = collect(iterator_to_array($cursor, false))->first();
            $latestDate = $latest->_id ?? null;

            if ($latestDate === null) {
                return [
                    'period' => null,
                    'items' => collect(),
                ];
            }

            $rows = DB::connection('mongodb')
                ->table('prediction_results')
                ->where('tanggal', $latestDate)
                ->get();

            return [
                'period' => $latestDate,
                'items' => collect($rows)
                    ->filter(fn ($row) => ($row->mae ?? null) !== null && ($row->rmse ?? null) !== null)
                    ->mapWithKeys(function ($row) {
                        return [
                            (string) ($row->product_id ?? '') => [
                                'mae' => $row->mae ?? null,
                                'rmse' => $row->rmse ?? null,
                                'validation_mae' => $row->validation_mae ?? null,
                                'validation_rmse' => $row->validation_rmse ?? null,
                                'accuracy' => (($row->predicted_sales ?? 0) > 0 && ($row->mae ?? null) !== null)
                                    ? max(0, min(100, 100 - (($row->mae / $row->predicted_sales) * 100)))
                                    : null,
                            ],
                        ];
                    }),
            ];
        } catch (\Throwable $e) {
            return [
                'period' => null,
                'items' => collect(),
            ];
        }
    }

    private function getAvailablePredictionPeriods()
    {
        try {
            $cursor = DB::connection('mongodb')->getCollection('prediction_results')->aggregate([
                ['$match' => ['tanggal' => ['$type' => 'string']]],
                ['$project' => ['period' => ['$substr' => ['$tanggal', 0, 7]]]],
                ['$match' => ['period' => ['$regex' => '^[0-9]{4}-[0-9]{2}$']]],
                ['$group' => ['_id' => '$period']],
                ['$sort' => ['_id' => 1]],
            ]);

            Carbon::setLocale('id');

            return collect(iterator_to_array($cursor, false))
                ->map(function ($row) {
                    $period = (string) ($row->_id ?? '');

                    if ($period === '') {
                        return null;
                    }

                    return [
                        'value' => $period,
                        'label' => Carbon::createFromFormat('Y-m', $period)
                            ->translatedFormat('F Y'),
                    ];
                })
                ->filter()
                ->values();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function getNextPredictionPeriod(Collection $availablePredictionPeriods, string $selectedPeriod): array
    {
        $latestAvailable = $availablePredictionPeriods->last();
        $basePeriod = $latestAvailable['value'] ?? $selectedPeriod;

        try {
            $nextPeriod = Carbon::createFromFormat('Y-m', $basePeriod)->addMonth();
        } catch (\Throwable $e) {
            $nextPeriod = Carbon::createFromFormat('Y-m', $this->getDefaultPredictionPeriod())->addMonth();
        }

        return [
            'value' => $nextPeriod->format('Y-m'),
            'label' => $nextPeriod->translatedFormat('F Y'),
        ];
    }

    // =========================================================
    // HELPER — Ambil Periode Default dari Tanggal Terakhir Dataset
    // =========================================================
    private function getDefaultPredictionPeriod()
{
    /*
    |--------------------------------------------------------------------------
    | Periode Default Berdasarkan Hasil Prediksi Aktif
    |--------------------------------------------------------------------------
    | Jika prediction_results sudah ada, halaman dashboard dan prediksi harus
    | mengikuti periode prediksi terbaru yang benar-benar sudah tersedia.
    |
    | Ini mencegah periode otomatis lompat ke bulan transaksi mobile terbaru,
    | misalnya Juni 2026, padahal hasil prediksi yang tersimpan masih Januari 2024.
    |--------------------------------------------------------------------------
    */
    $latestPrediction = DB::connection('mongodb') // pakai koneksi MongoDB Atlas
        ->table('prediction_results')             // ambil dari hasil prediksi, bukan transaksi
        ->orderByDesc('tanggal')                  // cari tanggal prediksi terbaru
        ->first();                                // ambil satu data paling baru

    if ($latestPrediction && !empty($latestPrediction->tanggal)) { // kalau prediksi sudah pernah digenerate
        return Carbon::parse($latestPrediction->tanggal)           // contoh: 2024-01-31
            ->format('Y-m');                                       // ubah jadi periode: 2024-01
    }

    /*
    |--------------------------------------------------------------------------
    | Fallback Jika Belum Ada Hasil Prediksi
    |--------------------------------------------------------------------------
    | Jika prediction_results masih kosong, baru gunakan tanggal terakhir
    | dari collection penjualans + 1 bulan.
    |--------------------------------------------------------------------------
    */
    $lastSale = DB::connection('mongodb') // tetap pakai MongoDB
        ->table('penjualans')             // fallback ke data penjualan historis
        ->orderByDesc('tanggal')          // cari tanggal penjualan terbaru
        ->first();                        // ambil satu data terakhir

    if (!$lastSale || empty($lastSale->tanggal)) { // kalau penjualan juga kosong
        return now()->addMonth()->format('Y-m');   // fallback aman ke bulan depan dari hari ini
    }

    return Carbon::parse($lastSale->tanggal) // contoh: 2023-12-31
        ->addMonth()                         // jadi bulan berikutnya
        ->format('Y-m');                     // contoh: 2024-01
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

    private function getActiveProductIds(): array
    {
        return DB::connection('mongodb')
            ->table('products')
            ->get()
            ->filter(fn ($product) => (int) ($product->is_active ?? 1) === 1)
            ->map(fn ($product) => (int) ($product->id ?? $product->_id ?? 0))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();
    }
}
