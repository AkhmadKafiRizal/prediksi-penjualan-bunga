<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    protected string $csvFile;
    protected string $timeFile;

    public function __construct()
    {
        $this->csvFile = base_path('dataset/cleaned_flower_sales_dataset.csv');
        $this->timeFile = storage_path('app/dataset_time.txt');
    }

    // ── Helper: baca CSV ──────────────────────────────────────────
    private function readCsv(): array
    {
        $header = [];
        $rows   = [];

        if (!file_exists($this->csvFile)) return compact('header', 'rows');

        if (($handle = fopen($this->csvFile, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }

        return compact('header', 'rows');
    }

    // ── Helper: tulis ulang CSV ───────────────────────────────────
    private function writeCsv(array $header, array $rows): void
    {
        $handle = fopen($this->csvFile, 'w');
        fputcsv($handle, $header);
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

    // ── Helper: waktu upload ──────────────────────────────────────
    private function lastUpload(): ?string
    {
        return file_exists($this->timeFile)
            ? file_get_contents($this->timeFile)
            : null;
    }

    // ==============================================================
    // INDEX
    // ==============================================================
    public function index(Request $request)
    {
        ['header' => $header, 'rows' => $rows] = $this->readCsv();

        $search = $request->query('search');
        if ($search) {
            $rows = array_values(array_filter($rows, function ($row) use ($search) {
                foreach ($row as $cell) {
                    if (stripos($cell, $search) !== false) return true;
                }
                return false;
            }));
        }

        return view('sales', [
            'header'     => $header,
            'rows'       => $rows,
            'lastUpload' => $this->lastUpload(),
            'search'     => $search,
        ]);
    }

    // ==============================================================
    // UPLOAD — ganti seluruh dataset
    // ==============================================================
    public function upload(Request $request)
    {
        $request->validate([
            'dataset' => 'required|mimes:csv,txt'
        ]);

        $request->file('dataset')->move(
            base_path('dataset'),
            'cleaned_flower_sales_dataset.csv'
        );

        file_put_contents($this->timeFile, date('d-m-Y H:i:s'));

        return redirect()->route('sales')
            ->with('success', 'Dataset berhasil diperbarui.');
    }

    // ==============================================================
    // UPDATE — edit 1 baris
    // ==============================================================
    public function update(Request $request, int $index)
    {
        $request->validate([
            'YEAR_MONTH'      => 'required|string|max:7',
            'quantityOrdered' => 'required|numeric|min:0',
            'sales'           => 'required|numeric|min:0',
        ]);

        ['header' => $header, 'rows' => $rows] = $this->readCsv();

        if (!isset($rows[$index])) {
            return redirect()->route('sales')->with('error', 'Data tidak ditemukan.');
        }

        $rows[$index] = [
            $request->YEAR_MONTH,
            $request->quantityOrdered,
            $request->sales,
        ];

        usort($rows, fn($a, $b) => strcmp($a[0], $b[0]));
        $this->writeCsv($header, $rows);

        return redirect()->route('sales')
            ->with('success', 'Data periode ' . $request->YEAR_MONTH . ' berhasil diperbarui.');
    }

    // ==============================================================
    // DESTROY — hapus 1 baris
    // ==============================================================
    public function destroy(int $index)
    {
        ['header' => $header, 'rows' => $rows] = $this->readCsv();

        if (!isset($rows[$index])) {
            return redirect()->route('sales')->with('error', 'Data tidak ditemukan.');
        }

        $deleted = $rows[$index][0] ?? $index;
        array_splice($rows, $index, 1);
        $this->writeCsv($header, $rows);

        return redirect()->route('sales')
            ->with('success', 'Data periode ' . $deleted . ' berhasil dihapus.');
    }
}