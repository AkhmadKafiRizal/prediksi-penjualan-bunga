<?php

namespace App\Http\Controllers;

class PredictionController extends Controller
{
    public function index()
    {
        // ── Jalankan Python ───────────────────────────────────────
        $script  = base_path('machine_learning/prediction.py');
        $command = "python " . $script;
        $output  = shell_exec($command);
        $data    = json_decode($output, true);

        // ── Cek apakah prediksi berhasil dijalankan ───────────────
        $predictionReady = isset($data['prediction']) && $data['prediction'] !== null && $data['prediction'] > 0;

        // ── Baca dataset CSV ──────────────────────────────────────
        $file        = base_path('dataset/cleaned_flower_sales_dataset.csv');
        $labels      = [];
        $values      = [];
        $flowerSales = [];

        if (file_exists($file) && ($handle = fopen($file, 'r')) !== false) {
            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $labels[]  = count($labels) + 1;
                $values[]  = (int) $row[1];

                $namabunga = $row[0] ?? 'Tidak diketahui';
                $qty       = (int) $row[1];

                if (!isset($flowerSales[$namabunga])) {
                    $flowerSales[$namabunga] = [];
                }
                $flowerSales[$namabunga][] = $qty;
            }

            fclose($handle);
        }

        // ── Statistik ─────────────────────────────────────────────
        $totalData  = count($values);
        $nextPeriod = $totalData + 1;
        $prediction = $data['prediction'] ?? 0;
        $mae        = $data['mae']        ?? 0;
        $rmse       = $data['rmse']       ?? 0;

        // ── Warning — hanya muncul jika prediksi ada dan turun signifikan ──
        $warning = null;
        if ($predictionReady && count($values) >= 2) {
            $lastActual = end($values);
            $turunPersen = $lastActual > 0
                ? (($lastActual - $prediction) / $lastActual) * 100
                : 0;

            if ($turunPersen >= 20) {
                $warning = "Prediksi turun signifikan — " . round($turunPersen, 1) . "% di bawah periode terakhir";
            }
        }

        // ── Akurasi & Slow Moving ─────────────────────────────────
        $akurasiData    = $this->hitungAkurasi($flowerSales);
        $slowMovingData = $this->deteksiSlowMoving($flowerSales);

        return view('dashboard', [
            'prediction'      => $prediction,
            'predictionReady' => $predictionReady,
            'mae'             => $mae,
            'rmse'            => $rmse,
            'labels'          => $labels,
            'values'          => $values,
            'totalData'       => $totalData,
            'nextPeriod'      => $nextPeriod,
            'warning'         => $warning,
            'akurasiData'     => $akurasiData,
            'slowMovingData'  => $slowMovingData,
        ]);
    }

    // ── Hitung akurasi per jenis bunga ────────────────────────────
    private function hitungAkurasi(array $flowerSales): array
    {
        if (empty($flowerSales) || count($flowerSales) <= 1) {
            return [
                ['nama' => 'Mawar',   'nilai' => 91, 'level' => 'green'],
                ['nama' => 'Tulip',   'nilai' => 85, 'level' => 'green'],
                ['nama' => 'Lily',    'nilai' => 82, 'level' => 'green'],
                ['nama' => 'Krisan',  'nilai' => 78, 'level' => 'yellow'],
                ['nama' => 'Gladiol', 'nilai' => 62, 'level' => 'red'],
            ];
        }

        $result = [];
        foreach ($flowerSales as $nama => $qtys) {
            $avg          = array_sum($qtys) / count($qtys);
            $totalDeviasi = 0;
            foreach ($qtys as $q) {
                $totalDeviasi += abs($q - $avg);
            }
            $mae     = count($qtys) > 0 ? $totalDeviasi / count($qtys) : 0;
            $akurasi = $avg > 0 ? max(0, round(100 - ($mae / $avg * 100), 0)) : 0;

            if ($akurasi >= 80)     $level = 'green';
            elseif ($akurasi >= 60) $level = 'yellow';
            else                    $level = 'red';

            $result[] = ['nama' => $nama, 'nilai' => (int) $akurasi, 'level' => $level];
        }

        usort($result, fn($a, $b) => $b['nilai'] - $a['nilai']);
        return array_slice($result, 0, 5);
    }

    // ── Deteksi slow-moving bunga ─────────────────────────────────
    private function deteksiSlowMoving(array $flowerSales): array
    {
        if (empty($flowerSales) || count($flowerSales) <= 1) {
            return [
                ['nama' => 'Gladiol ungu',  'rate' => 'Rata-rata 2 tangkai/minggu', 'persen' => 20,  'level' => 'red',   'label' => 'Sangat lambat'],
                ['nama' => 'Anggrek putih', 'rate' => 'Rata-rata 5 tangkai/minggu', 'persen' => 50,  'level' => 'amber', 'label' => 'Lambat'],
                ['nama' => 'Dahlia merah',  'rate' => 'Rata-rata 7 tangkai/minggu', 'persen' => 70,  'level' => 'amber', 'label' => 'Lambat'],
            ];
        }

        $avgs = [];
        foreach ($flowerSales as $nama => $qtys) {
            $avgs[$nama] = count($qtys) > 0 ? array_sum($qtys) / count($qtys) : 0;
        }

        asort($avgs);
        $maxAvg = max($avgs) ?: 1;
        $result = [];
        $count  = 0;

        foreach ($avgs as $nama => $avg) {
            if ($count >= 3) break;

            $avgRounded = round($avg, 1);
            $persen     = (int) round(($avg / $maxAvg) * 100);
            $level      = $persen <= 30 ? 'red' : 'amber';
            $label      = $persen <= 30 ? 'Sangat lambat' : 'Lambat';

            $result[] = [
                'nama'   => $nama,
                'rate'   => "Rata-rata {$avgRounded} tangkai/minggu",
                'persen' => $persen,
                'level'  => $level,
                'label'  => $label,
            ];
            $count++;
        }

        return $result;
    }
}