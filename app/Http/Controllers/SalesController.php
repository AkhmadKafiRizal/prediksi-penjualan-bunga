<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    protected string $timeFile;

    public function __construct()
    {
        $this->timeFile = storage_path('app/dataset_time.txt');
    }

    private function lastUpload(): ?string
    {
        return file_exists($this->timeFile)
            ? file_get_contents($this->timeFile)
            : null;
    }

    private function mongo()
    {
        return DB::connection('mongodb');
    }

    private function getProductNames()
    {
        return $this->mongo()
            ->table('products')
            ->pluck('nama_bunga', 'id');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $productNames = $this->getProductNames();

        $dataset = $this->mongo()
            ->table('penjualans')
            ->orderBy('tanggal', 'desc')
            ->orderBy('product_id', 'asc')
            ->get()
            ->map(function ($item) use ($productNames) {
                $item->nama_bunga = $productNames[$item->product_id] ?? 'Produk #' . $item->product_id;
                return $item;
            });

        if ($search) {
            $searchLower = strtolower($search);

            $dataset = $dataset->filter(function ($item) use ($searchLower) {
                return str_contains(strtolower((string) ($item->tanggal ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->product_id ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->nama_bunga ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->jumlah ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->harga ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->promo ?? '')), $searchLower);
            })->values();
        }

        $perPage = 25;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $rows = new LengthAwarePaginator(
            $dataset->forPage($currentPage, $perPage)->values(),
            $dataset->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $allSales = $this->mongo()
            ->table('penjualans')
            ->get();

        $totalData = $allSales->count();

        $totalProduk = $allSales
            ->pluck('product_id')
            ->unique()
            ->count();

        $firstDate = $allSales->min('tanggal');
        $lastDate = $allSales->max('tanggal');

        $periodeDataset = '-';

        if ($firstDate && $lastDate) {
            $periodeDataset =
                date('F Y', strtotime($firstDate))
                . ' – ' .
                date('F Y', strtotime($lastDate));
        }

        $datasetReady = $totalData > 0 && $totalProduk > 0;

        return view('sales', [
            'rows'           => $rows,
            'lastUpload'     => $this->lastUpload(),
            'search'         => $search,
            'totalData'      => $totalData,
            'totalProduk'    => $totalProduk,
            'periodeDataset' => $periodeDataset,
            'datasetReady'   => $datasetReady,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'dataset' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('dataset');
        $handle = fopen($file->getRealPath(), 'r');

        if (!$handle) {
            return redirect()->route('sales')
                ->with('error', 'File CSV gagal dibaca.');
        }

        $header = fgetcsv($handle);

        $expectedHeader = [
            'product_id',
            'tanggal',
            'jumlah',
            'harga',
            'promo',
        ];

        if ($header !== $expectedHeader) {
            fclose($handle);

            return redirect()->route('sales')
                ->with('error', 'Header CSV tidak sesuai. Wajib: product_id,tanggal,jumlah,harga,promo');
        }

        try {
            $imported = 0;
            $skippedDuplicate = 0;
            $rowNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                if (count($row) !== 5) {
                    throw new \Exception("Jumlah kolom salah pada baris {$rowNumber}.");
                }

                $productId = (int) trim($row[0]);
                $tanggal = trim($row[1]);
                $jumlah = (int) trim($row[2]);
                $harga = (float) trim($row[3]);
                $promo = (int) trim($row[4]);

                if ($productId <= 0) {
                    throw new \Exception("product_id tidak valid pada baris {$rowNumber}.");
                }

                if (!strtotime($tanggal)) {
                    throw new \Exception("tanggal tidak valid pada baris {$rowNumber}.");
                }

                if ($jumlah < 0) {
                    throw new \Exception("jumlah tidak boleh negatif pada baris {$rowNumber}.");
                }

                if ($harga < 0) {
                    throw new \Exception("harga tidak boleh negatif pada baris {$rowNumber}.");
                }

                if (!in_array($promo, [0, 1], true)) {
                    throw new \Exception("promo harus 0 atau 1 pada baris {$rowNumber}.");
                }

                $formattedTanggal = date('Y-m-d', strtotime($tanggal));

                $isDuplicate = $this->mongo()
                    ->table('penjualans')
                    ->where('product_id', $productId)
                    ->where('tanggal', $formattedTanggal)
                    ->where('jumlah', $jumlah)
                    ->where('harga', $harga)
                    ->where('promo', $promo)
                    ->exists();

                if ($isDuplicate) {
                    $skippedDuplicate++;
                    continue;
                }

                $latestId = $this->mongo()
                    ->table('penjualans')
                    ->max('id');

                $newId = ((int) $latestId) + 1;

                $this->mongo()
                    ->table('penjualans')
                    ->insert([
                        'id'         => $newId,
                        'product_id' => $productId,
                        'tanggal'    => $formattedTanggal,
                        'jumlah'     => $jumlah,
                        'harga'      => $harga,
                        'promo'      => $promo,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                $imported++;
            }

            fclose($handle);

            file_put_contents($this->timeFile, date('d-m-Y H:i:s'));

            return redirect()->route('sales')
                ->with('success', "Import CSV berhasil ke MongoDB. Data masuk: {$imported}. Duplikat dilewati: {$skippedDuplicate}.");

        } catch (\Exception $e) {
            fclose($handle);

            return redirect()->route('sales')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_id' => 'required|integer|min:1',
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:0',
            'harga'      => 'required|numeric|min:0',
            'promo'      => 'required|numeric|min:0|max:1',
        ]);

        $exists = $this->mongo()
            ->table('penjualans')
            ->where('id', $id)
            ->exists();

        if (!$exists) {
            return redirect()->route('sales')->with('error', 'Data tidak ditemukan.');
        }

        $this->mongo()
            ->table('penjualans')
            ->where('id', $id)
            ->update([
                'product_id' => (int) $request->product_id,
                'tanggal'    => date('Y-m-d', strtotime($request->tanggal)),
                'jumlah'     => (int) $request->jumlah,
                'harga'      => (float) $request->harga,
                'promo'      => (int) $request->promo,
                'updated_at' => now(),
            ]);

        return redirect()->route('sales')
            ->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $exists = $this->mongo()
            ->table('penjualans')
            ->where('id', $id)
            ->exists();

        if (!$exists) {
            return redirect()->route('sales')->with('error', 'Data tidak ditemukan.');
        }

        $this->mongo()
            ->table('penjualans')
            ->where('id', $id)
            ->delete();

        return redirect()->route('sales')
            ->with('success', 'Data penjualan berhasil dihapus.');
    }
}