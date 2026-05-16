<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
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
        $search        = $request->query('search');
        $filterTahun   = $request->query('tahun');
        $filterBulan   = $request->query('bulan');
        $filterTanggal = $request->query('tanggal');

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

        // Filter tahun
        if ($filterTahun) {
            $dataset = $dataset->filter(fn($item) =>
                date('Y', strtotime($item->tanggal)) == $filterTahun
            )->values();
        }

        // Filter bulan
        if ($filterBulan) {
            $dataset = $dataset->filter(fn($item) =>
                (int) date('n', strtotime($item->tanggal)) === (int) $filterBulan
            )->values();
        }

        // Filter tanggal (hari)
        if ($filterTanggal) {
            $dataset = $dataset->filter(fn($item) =>
                (int) date('j', strtotime($item->tanggal)) === (int) $filterTanggal
            )->values();
        }

        // Search
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

        $perPage     = 25;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $rows = new LengthAwarePaginator(
            $dataset->forPage($currentPage, $perPage)->values(),
            $dataset->count(),
            $perPage,
            $currentPage,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Stats dari semua data (tanpa filter)
        $allSales = $this->mongo()->table('penjualans')->get();

        $totalData   = $allSales->count();
        $totalProduk = $allSales->pluck('product_id')->unique()->count();

        $firstDate = $allSales->min('tanggal');
        $lastDate  = $allSales->max('tanggal');

        $periodeDataset = '-';
        if ($firstDate && $lastDate) {
            $periodeDataset = date('F Y', strtotime($firstDate))
                . ' – '
                . date('F Y', strtotime($lastDate));
        }

        // Daftar tahun tersedia untuk dropdown filter
        $availableYears = $allSales
            ->map(fn($item) => date('Y', strtotime($item->tanggal)))
            ->unique()
            ->sort()
            ->values();

        $datasetReady = $totalData > 0 && $totalProduk > 0;

        return view('sales', [
            'rows'           => $rows,
            'search'         => $search,
            'filterTahun'    => $filterTahun,
            'filterBulan'    => $filterBulan,
            'filterTanggal'  => $filterTanggal,
            'availableYears' => $availableYears,
            'totalData'      => $totalData,
            'totalProduk'    => $totalProduk,
            'periodeDataset' => $periodeDataset,
            'datasetReady'   => $datasetReady,
            'lastUpload'     => null, // tidak dipakai lagi, bisa dihapus
        ]);
    }

    public function export(Request $request)
    {
        $search        = $request->query('search');
        $filterTahun   = $request->query('tahun');
        $filterBulan   = $request->query('bulan');
        $filterTanggal = $request->query('tanggal');

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

        if ($filterTahun) {
            $dataset = $dataset->filter(fn($item) =>
                date('Y', strtotime($item->tanggal)) == $filterTahun
            )->values();
        }

        if ($filterBulan) {
            $dataset = $dataset->filter(fn($item) =>
                (int) date('n', strtotime($item->tanggal)) === (int) $filterBulan
            )->values();
        }

        if ($filterTanggal) {
            $dataset = $dataset->filter(fn($item) =>
                (int) date('j', strtotime($item->tanggal)) === (int) $filterTanggal
            )->values();
        }

        if ($search) {
            $searchLower = strtolower($search);
            $dataset = $dataset->filter(function ($item) use ($searchLower) {
                return str_contains(strtolower((string) ($item->tanggal ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->product_id ?? '')), $searchLower)
                    || str_contains(strtolower((string) ($item->nama_bunga ?? '')), $searchLower);
            })->values();
        }

        // Buat nama file berdasarkan filter aktif
        $suffix = '';
        if ($filterTahun)   $suffix .= '_' . $filterTahun;
        if ($filterBulan)   $suffix .= '_bulan' . $filterBulan;
        if ($filterTanggal) $suffix .= '_tgl' . $filterTanggal;
        $filename = 'penjualan' . $suffix . '_' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($dataset) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, ['id', 'product_id', 'nama_bunga', 'tanggal', 'jumlah', 'harga', 'promo']);

            foreach ($dataset as $row) {
                fputcsv($handle, [
                    $row->id         ?? '',
                    $row->product_id ?? '',
                    $row->nama_bunga ?? '',
                    $row->tanggal    ?? '',
                    $row->jumlah     ?? '',
                    $row->harga      ?? '',
                    $row->promo      ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}