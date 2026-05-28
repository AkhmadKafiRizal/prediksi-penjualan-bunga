<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\Regex;
use Throwable;

class SalesController extends Controller
{
    private const PER_PAGE = 25;

    private function mongo()
    {
        return DB::connection('mongodb');
    }

    private function salesQuery()
    {
        return $this->mongo()->table('penjualans');
    }

    private function getProductNames()
    {
        return $this->mongo()
            ->table('products')
            ->pluck('nama_bunga', 'id');
    }

    private function productNameFor($productNames, $productId): string
    {
        return $productNames->get($productId)
            ?? $productNames->get((string) $productId)
            ?? 'Produk #' . $productId;
    }

    private function withProductName($row, $productNames)
    {
        $productId = $row->product_id ?? null;

        $row->id = $row->id ?? (isset($row->_id) ? (string) $row->_id : '');
        $row->nama_bunga = $this->productNameFor($productNames, $productId);
        $row->kasir_name = $this->cashierNameFor($row);

        return $row;
    }

    private function cashierNameFor($row): string
    {
        return $row->kasir_name
            ?? $row->cashier_name
            ?? $row->user_name
            ?? 'Data historis';
    }

    private function applyRequestFilters($query, Request $request)
    {
        $this->applyDateFilters(
            $query,
            $request->query('tahun'),
            $request->query('bulan'),
            $request->query('tanggal')
        );

        $search = trim((string) $request->query('search', ''));

        if ($search !== '') {
            $this->applySearchFilter($query, $search);
        }

        return $query;
    }

    private function applyDateFilters($query, $year, $month, $day): void
    {
        $year = $this->normalizeInt($year, 1900, 3000);
        $month = $this->normalizeInt($month, 1, 12);
        $day = $this->normalizeInt($day, 1, 31);

        if ($year && $month && $day) {
            if (checkdate($month, $day, $year)) {
                $query->where('tanggal', sprintf('%04d-%02d-%02d', $year, $month, $day));
                return;
            }

            $query->where('tanggal', '__invalid_date__');
            return;
        }

        if ($year && $month) {
            $start = Carbon::create($year, $month, 1)->format('Y-m-d');
            $end = Carbon::create($year, $month, 1)->endOfMonth()->format('Y-m-d');

            $query->where('tanggal', '>=', $start)
                ->where('tanggal', '<=', $end);

            return;
        }

        if ($year && $day) {
            $query->where('tanggal', 'regex', new Regex(sprintf('^%04d-[0-9]{2}-%02d$', $year, $day)));
            return;
        }

        if ($year) {
            $query->where('tanggal', '>=', sprintf('%04d-01-01', $year))
                ->where('tanggal', '<=', sprintf('%04d-12-31', $year));

            return;
        }

        if ($month && $day) {
            $query->where('tanggal', 'regex', new Regex(sprintf('^[0-9]{4}-%02d-%02d$', $month, $day)));
            return;
        }

        if ($month) {
            $query->where('tanggal', 'regex', new Regex(sprintf('^[0-9]{4}-%02d-', $month)));
            return;
        }

        if ($day) {
            $query->where('tanggal', 'regex', new Regex(sprintf('^[0-9]{4}-[0-9]{2}-%02d$', $day)));
        }
    }

    private function applySearchFilter($query, string $search): void
    {
        $regex = new Regex(preg_quote($search), 'i');
        $productIds = $this->matchingProductIds($regex);

        $query->where(function ($inner) use ($regex, $productIds, $search) {
            $inner->where('tanggal', 'regex', $regex)
                ->orWhere('invoice_number', 'regex', $regex)
                ->orWhere('kasir_name', 'regex', $regex)
                ->orWhere('cashier_name', 'regex', $regex)
                ->orWhere('source', 'regex', $regex);

            if (! empty($productIds)) {
                $inner->orWhereIn('product_id', $productIds);
            }

            if (is_numeric($search)) {
                $number = (float) $search;
                $integer = (int) $search;

                $inner->orWhere('product_id', $integer)
                    ->orWhere('jumlah', $integer)
                    ->orWhere('harga', $number)
                    ->orWhere('promo', $integer)
                    ->orWhere('id', $integer)
                    ->orWhere('transaction_number', $integer);
            }
        });
    }

    private function matchingProductIds(Regex $regex): array
    {
        return $this->mongo()
            ->table('products')
            ->where('nama_bunga', 'regex', $regex)
            ->pluck('id')
            ->filter(fn ($id) => $id !== null && $id !== '')
            ->flatMap(fn ($id) => is_numeric($id) ? [(int) $id, (string) $id] : [$id])
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeInt($value, int $min, int $max): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        $value = (int) $value;

        return $value >= $min && $value <= $max ? $value : null;
    }

    private function getSalesStats(): array
    {
        $cursor = $this->mongo()->getCollection('penjualans')->aggregate([
            [
                '$group' => [
                    '_id' => null,
                    'totalData' => ['$sum' => 1],
                    'productIds' => ['$addToSet' => '$product_id'],
                    'firstDate' => ['$min' => '$tanggal'],
                    'lastDate' => ['$max' => '$tanggal'],
                ],
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'totalData' => 1,
                    'totalProduk' => ['$size' => '$productIds'],
                    'firstDate' => 1,
                    'lastDate' => 1,
                ],
            ],
        ]);

        $stats = iterator_to_array($cursor, false)[0] ?? null;

        return [
            'totalData' => (int) ($stats->totalData ?? 0),
            'totalProduk' => (int) ($stats->totalProduk ?? 0),
            'firstDate' => $stats->firstDate ?? null,
            'lastDate' => $stats->lastDate ?? null,
        ];
    }

    private function getAvailableYears()
    {
        $cursor = $this->mongo()->getCollection('penjualans')->aggregate([
            ['$match' => ['tanggal' => ['$type' => 'string']]],
            ['$project' => ['year' => ['$substr' => ['$tanggal', 0, 4]]]],
            ['$match' => ['year' => ['$regex' => '^[0-9]{4}$']]],
            ['$group' => ['_id' => '$year']],
            ['$sort' => ['_id' => 1]],
        ]);

        return collect(iterator_to_array($cursor, false))
            ->pluck('_id')
            ->values();
    }

    private function formatPeriodLabel($firstDate, $lastDate): string
    {
        if (! $firstDate || ! $lastDate) {
            return '-';
        }

        return date('F Y', strtotime($firstDate))
            . ' - '
            . date('F Y', strtotime($lastDate));
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $filterTahun = $request->query('tahun');
        $filterBulan = $request->query('bulan');
        $filterTanggal = $request->query('tanggal');

        $perPage = self::PER_PAGE;
        $currentPage = max(1, (int) LengthAwarePaginator::resolveCurrentPage());
        $databaseError = null;

        try {
            $productNames = $this->getProductNames();
            $query = $this->applyRequestFilters($this->salesQuery(), $request);

            $totalFiltered = (clone $query)->count();

            $rows = $query
                ->orderBy('tanggal', 'desc')
                ->orderBy('product_id', 'asc')
                ->skip(($currentPage - 1) * $perPage)
                ->take($perPage)
                ->get()
                ->map(fn ($item) => $this->withProductName($item, $productNames));

            $stats = $this->getSalesStats();
            $totalData = $stats['totalData'];
            $totalProduk = $stats['totalProduk'];
            $periodeDataset = $this->formatPeriodLabel($stats['firstDate'], $stats['lastDate']);
            $availableYears = $this->getAvailableYears();
        } catch (Throwable $e) {
            $rows = collect();
            $totalFiltered = 0;
            $totalData = 0;
            $totalProduk = 0;
            $periodeDataset = '-';
            $availableYears = collect();
            $databaseError = 'Data penjualan belum bisa dimuat. Periksa koneksi MongoDB/Atlas atau konfigurasi MONGODB_URI.';
        }

        $rows = new LengthAwarePaginator(
            $rows,
            $totalFiltered,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $datasetReady = $totalData > 0 && $totalProduk > 0 && ! $databaseError;

        return view('sales', [
            'rows' => $rows,
            'search' => $search,
            'filterTahun' => $filterTahun,
            'filterBulan' => $filterBulan,
            'filterTanggal' => $filterTanggal,
            'availableYears' => $availableYears,
            'totalData' => $totalData,
            'totalProduk' => $totalProduk,
            'periodeDataset' => $periodeDataset,
            'datasetReady' => $datasetReady,
            'lastUpload' => null,
            'databaseError' => $databaseError,
        ]);
    }

    public function export(Request $request)
    {
        $filterTahun = $request->query('tahun');
        $filterBulan = $request->query('bulan');
        $filterTanggal = $request->query('tanggal');

        $productNames = $this->getProductNames();
        $query = $this->applyRequestFilters($this->salesQuery(), $request)
            ->orderBy('tanggal', 'desc')
            ->orderBy('product_id', 'asc');

        $suffix = '';
        if ($filterTahun) {
            $suffix .= '_' . $filterTahun;
        }
        if ($filterBulan) {
            $suffix .= '_bulan' . $filterBulan;
        }
        if ($filterTanggal) {
            $suffix .= '_tgl' . $filterTanggal;
        }

        $filename = 'penjualan' . $suffix . '_' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($query, $productNames) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['id', 'product_id', 'nama_bunga', 'tanggal', 'jumlah', 'harga', 'promo', 'kasir']);

            foreach ($query->cursor() as $row) {
                $row = $this->withProductName($row, $productNames);

                fputcsv($handle, [
                    $row->id ?? '',
                    $row->product_id ?? '',
                    $row->nama_bunga ?? '',
                    $row->tanggal ?? '',
                    $row->jumlah ?? '',
                    $row->harga ?? '',
                    $row->promo ?? '',
                    $row->kasir_name ?? 'Data historis',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
