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
    private const EXPORT_CHUNK_SIZE = 1000;

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
        $row->display_id = $this->displayIdFor($row);
        $row->nama_bunga = $this->productNameFor($productNames, $productId);
        $row->kasir_name = $this->cashierNameFor($row);

        return $row;
    }

    private function displayIdFor($row): string
    {
        $transactionNumber = $row->transaction_number ?? null;

        if ($transactionNumber !== null && $transactionNumber !== '') {
            return (string) $transactionNumber;
        }

        $legacyId = $row->id ?? null;

        if ($legacyId !== null && $legacyId !== '') {
            return (string) $legacyId;
        }

        return isset($row->_id) ? (string) $row->_id : '';
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

        return Carbon::parse($firstDate)->locale('id')->translatedFormat('F Y')
            . ' - '
            . Carbon::parse($lastDate)->locale('id')->translatedFormat('F Y');
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
        @set_time_limit(0);

        $filterTahun = $request->query('tahun');
        $filterBulan = $request->query('bulan');
        $filterTanggal = $request->query('tanggal');

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
        $filePath = null;

        try {
            $productNames = $this->getProductNames();
            $filePath = $this->createSalesCsv($request, $productNames);

            return response()
                ->download($filePath, $filename, [
                    'Content-Type' => 'text/csv; charset=UTF-8',
                ])
                ->deleteFileAfterSend(true);
        } catch (Throwable $e) {
            if ($filePath && file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->route('sales', $request->only(['search', 'tahun', 'bulan', 'tanggal']))
                ->with('error', 'Export CSV belum berhasil karena data penjualan belum selesai dibaca dari MongoDB. Coba ulangi beberapa saat lagi.');
        }
    }

    private function createSalesCsv(Request $request, $productNames): string
    {
        $filePath = tempnam(storage_path('app'), 'sales-');
        $handle = fopen($filePath, 'w');

        if (! $handle) {
            throw new \RuntimeException('Gagal membuat file CSV penjualan.');
        }

        try {
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=;\r\n");

            fputcsv($handle, ['id', 'product_id', 'nama_bunga', 'tanggal', 'jumlah', 'harga', 'promo', 'kasir'], ';');

            $offset = 0;

            do {
                $rows = $this->applyRequestFilters($this->salesQuery(), $request)
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('product_id', 'asc')
                    ->skip($offset)
                    ->take(self::EXPORT_CHUNK_SIZE)
                    ->get();

                foreach ($rows as $row) {
                    $row = $this->withProductName($row, $productNames);

                    fputcsv($handle, [
                        $row->display_id ?? '',
                        $row->product_id ?? '',
                        $row->nama_bunga ?? '',
                        $row->tanggal ?? '',
                        $row->jumlah ?? '',
                        $row->harga ?? '',
                        $row->promo ?? '',
                        $row->kasir_name ?? 'Data historis',
                    ], ';');
                }

                $exportedCount = $rows->count();
                $offset += $exportedCount;
            } while ($exportedCount === self::EXPORT_CHUNK_SIZE);

            fclose($handle);

            return $filePath;
        } catch (Throwable $e) {
            fclose($handle);
            @unlink($filePath);

            throw $e;
        }
    }

    public function exportExcel(Request $request)
    {
        @set_time_limit(0);

        $filename = 'laporan-data-penjualan_' . date('Ymd') . '.xlsx';
        $filePath = null;

        try {
            $productNames = $this->getProductNames();
            $filePath = $this->createSalesWorkbook($request, $productNames);

            return response()
                ->download($filePath, $filename, [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->deleteFileAfterSend(true);
        } catch (Throwable $e) {
            if ($filePath && file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->route('sales', $request->only(['search', 'tahun', 'bulan', 'tanggal']))
                ->with('error', 'Export Excel belum berhasil karena data penjualan belum selesai dibaca dari MongoDB. Coba ulangi beberapa saat lagi.');
        }
    }

    private function createSalesWorkbook(Request $request, $productNames): string
    {
        $workbookPath = tempnam(storage_path('app'), 'sales-xlsx-');
        $sheetPath = tempnam(storage_path('app'), 'sales-sheet-');
        $zip = new \ZipArchive();

        try {
            $lastRow = $this->writeSalesWorksheet($sheetPath, $request, $productNames);

            if ($zip->open($workbookPath, \ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Gagal membuat file Excel penjualan.');
            }

            $zip->addFromString('[Content_Types].xml', $this->salesXlsxContentTypes());
            $zip->addFromString('_rels/.rels', $this->salesXlsxRootRelationships());
            $zip->addFromString('docProps/app.xml', $this->salesXlsxAppProperties());
            $zip->addFromString('docProps/core.xml', $this->salesXlsxCoreProperties());
            $zip->addFromString('xl/workbook.xml', $this->salesXlsxWorkbook());
            $zip->addFromString('xl/_rels/workbook.xml.rels', $this->salesXlsxWorkbookRelationships());
            $zip->addFromString('xl/styles.xml', $this->salesXlsxStyles());
            $zip->addFile($sheetPath, 'xl/worksheets/sheet1.xml');
            $zip->close();

            @unlink($sheetPath);

            if ($lastRow < 7) {
                throw new \RuntimeException('Data penjualan kosong.');
            }

            return $workbookPath;
        } catch (Throwable $e) {
            if ($zip instanceof \ZipArchive) {
                @$zip->close();
            }

            @unlink($sheetPath);
            @unlink($workbookPath);

            throw $e;
        }
    }

    private function writeSalesWorksheet(string $sheetPath, Request $request, $productNames): int
    {
        $writer = new \XMLWriter();

        if (! $writer->openUri($sheetPath)) {
            throw new \RuntimeException('Gagal menulis worksheet Excel penjualan.');
        }

        $filterLabel = $this->salesExportFilterLabel($request);
        $rowNumber = 1;

        $writer->startDocument('1.0', 'UTF-8', 'yes');
        $writer->startElement('worksheet');
        $writer->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $writer->writeAttribute('xmlns:r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');

        $writer->startElement('sheetViews');
        $writer->startElement('sheetView');
        $writer->writeAttribute('workbookViewId', '0');
        $writer->startElement('pane');
        $writer->writeAttribute('ySplit', '6');
        $writer->writeAttribute('topLeftCell', 'A7');
        $writer->writeAttribute('activePane', 'bottomLeft');
        $writer->writeAttribute('state', 'frozen');
        $writer->endElement();
        $writer->endElement();
        $writer->endElement();

        $writer->startElement('sheetFormatPr');
        $writer->writeAttribute('defaultRowHeight', '18');
        $writer->endElement();
        $writer->startElement('cols');
        foreach ([12, 12, 24, 14, 12, 14, 10, 18] as $index => $width) {
            $writer->startElement('col');
            $writer->writeAttribute('min', (string) ($index + 1));
            $writer->writeAttribute('max', (string) ($index + 1));
            $writer->writeAttribute('width', (string) $width);
            $writer->writeAttribute('customWidth', '1');
            $writer->endElement();
        }
        $writer->endElement();

        $writer->startElement('sheetData');

        $this->salesXlsxRow($writer, $rowNumber++, [
            ['type' => 'text', 'value' => 'FloraPredict - Laporan Data Penjualan Bunga', 'style' => 1],
        ], 28);
        $this->salesXlsxRow($writer, $rowNumber++, [
            ['type' => 'text', 'value' => 'Dataset penjualan historis dan transaksi mobile untuk validasi, analisis, dan kebutuhan machine learning.', 'style' => 2],
        ], 22);
        $this->salesXlsxRow($writer, $rowNumber++, []);
        $this->salesXlsxRow($writer, $rowNumber++, [
            ['type' => 'text', 'value' => 'Filter', 'style' => 3],
            ['type' => 'text', 'value' => $filterLabel, 'style' => 4],
            ['type' => 'text', 'value' => 'Diexport Pada', 'style' => 3],
            ['type' => 'text', 'value' => now()->format('d M Y, H:i') . ' WIB', 'style' => 4],
        ], 20);
        $this->salesXlsxRow($writer, $rowNumber++, []);
        $this->salesXlsxRow($writer, $rowNumber++, [
            ['type' => 'text', 'value' => 'ID', 'style' => 5],
            ['type' => 'text', 'value' => 'Product ID', 'style' => 5],
            ['type' => 'text', 'value' => 'Nama Bunga', 'style' => 5],
            ['type' => 'text', 'value' => 'Tanggal', 'style' => 5],
            ['type' => 'text', 'value' => 'Jumlah', 'style' => 5],
            ['type' => 'text', 'value' => 'Harga (Rp)', 'style' => 5],
            ['type' => 'text', 'value' => 'Status Promo', 'style' => 5],
            ['type' => 'text', 'value' => 'Kasir', 'style' => 5],
        ], 24);

        $offset = 0;

        do {
            $rows = $this->applyRequestFilters($this->salesQuery(), $request)
                ->orderBy('tanggal', 'desc')
                ->orderBy('product_id', 'asc')
                ->skip($offset)
                ->take(self::EXPORT_CHUNK_SIZE)
                ->get();

            foreach ($rows as $row) {
                $row = $this->withProductName($row, $productNames);
                $style = $rowNumber % 2 === 0 ? 7 : 6;

                $this->salesXlsxRow($writer, $rowNumber++, [
                    ['type' => 'text', 'value' => $row->display_id ?? '', 'style' => $style],
                    ['type' => is_numeric($row->product_id ?? null) ? 'number' : 'text', 'value' => $row->product_id ?? '', 'style' => $style],
                    ['type' => 'text', 'value' => $row->nama_bunga ?? '', 'style' => $style],
                    ['type' => 'text', 'value' => $row->tanggal ?? '', 'style' => $style],
                    ['type' => 'number', 'value' => $row->jumlah ?? 0, 'style' => $style],
                    ['type' => 'number', 'value' => ((float) ($row->harga ?? 0)) * 1000, 'style' => 8],
                    ['type' => 'text', 'value' => ((int) ($row->promo ?? 0)) === 1 ? 'Promo' : 'Tidak Promo', 'style' => $style],
                    ['type' => 'text', 'value' => $row->kasir_name ?? 'Data historis', 'style' => $style],
                ]);
            }

            $exportedCount = $rows->count();
            $offset += $exportedCount;
        } while ($exportedCount === self::EXPORT_CHUNK_SIZE);

        $lastDataRow = max(6, $rowNumber - 1);

        $writer->endElement();

        $writer->startElement('autoFilter');
        $writer->writeAttribute('ref', "A6:H{$lastDataRow}");
        $writer->endElement();

        $writer->startElement('mergeCells');
        $writer->writeAttribute('count', '2');
        foreach (['A1:H1', 'A2:H2'] as $ref) {
            $writer->startElement('mergeCell');
            $writer->writeAttribute('ref', $ref);
            $writer->endElement();
        }
        $writer->endElement();

        $writer->startElement('pageMargins');
        $writer->writeAttribute('left', '0.7');
        $writer->writeAttribute('right', '0.7');
        $writer->writeAttribute('top', '0.75');
        $writer->writeAttribute('bottom', '0.75');
        $writer->writeAttribute('header', '0.3');
        $writer->writeAttribute('footer', '0.3');
        $writer->endElement();

        $writer->endElement();
        $writer->endDocument();
        $writer->flush();

        return $lastDataRow;
    }

    private function salesXlsxRow(\XMLWriter $writer, int $rowNumber, array $cells, ?int $height = null): void
    {
        $writer->startElement('row');
        $writer->writeAttribute('r', (string) $rowNumber);

        if ($height) {
            $writer->writeAttribute('ht', (string) $height);
            $writer->writeAttribute('customHeight', '1');
        }

        foreach ($cells as $index => $cell) {
            $ref = $this->salesXlsxColumn($index + 1) . $rowNumber;
            $type = $cell['type'] ?? 'text';

            if ($type === 'number') {
                $this->salesXlsxNumberCell($writer, $ref, $cell['value'] ?? null, $cell['style'] ?? 0);
            } else {
                $this->salesXlsxTextCell($writer, $ref, (string) ($cell['value'] ?? ''), $cell['style'] ?? 0);
            }
        }

        $writer->endElement();
    }

    private function salesXlsxTextCell(\XMLWriter $writer, string $ref, string $value, int $style = 0): void
    {
        $writer->startElement('c');
        $writer->writeAttribute('r', $ref);
        $writer->writeAttribute('t', 'inlineStr');
        $writer->writeAttribute('s', (string) $style);
        $writer->startElement('is');
        $writer->writeElement('t', $value);
        $writer->endElement();
        $writer->endElement();
    }

    private function salesXlsxNumberCell(\XMLWriter $writer, string $ref, $value, int $style = 0): void
    {
        $writer->startElement('c');
        $writer->writeAttribute('r', $ref);
        $writer->writeAttribute('s', (string) $style);

        if ($value !== null && $value !== '') {
            $writer->writeElement('v', (string) (float) $value);
        }

        $writer->endElement();
    }

    private function salesXlsxColumn(int $index): string
    {
        $column = '';

        while ($index > 0) {
            $index--;
            $column = chr(65 + ($index % 26)) . $column;
            $index = intdiv($index, 26);
        }

        return $column;
    }

    private function salesExportFilterLabel(Request $request): string
    {
        $filters = [];

        if ($request->query('tahun')) {
            $filters[] = 'Tahun ' . $request->query('tahun');
        }

        if ($request->query('bulan')) {
            $filters[] = 'Bulan ' . $request->query('bulan');
        }

        if ($request->query('tanggal')) {
            $filters[] = 'Tanggal ' . $request->query('tanggal');
        }

        if ($request->query('search')) {
            $filters[] = 'Pencarian "' . $request->query('search') . '"';
        }

        return empty($filters) ? 'Semua data' : implode(' · ', $filters);
    }

    private function salesXlsxContentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>'
            . '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';
    }

    private function salesXlsxRootRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>'
            . '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>'
            . '</Relationships>';
    }

    private function salesXlsxWorkbookRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    private function salesXlsxWorkbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Data Penjualan" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private function salesXlsxCoreProperties(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<dc:title>FloraPredict - Laporan Data Penjualan Bunga</dc:title>'
            . '<dc:creator>FloraPredict</dc:creator>'
            . '<cp:lastModifiedBy>FloraPredict</cp:lastModifiedBy>'
            . '<dcterms:created xsi:type="dcterms:W3CDTF">' . now()->toISOString() . '</dcterms:created>'
            . '<dcterms:modified xsi:type="dcterms:W3CDTF">' . now()->toISOString() . '</dcterms:modified>'
            . '</cp:coreProperties>';
    }

    private function salesXlsxAppProperties(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">'
            . '<Application>FloraPredict</Application>'
            . '</Properties>';
    }

    private function salesXlsxStyles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="1"><numFmt numFmtId="164" formatCode="&quot;Rp&quot; #,##0"/></numFmts>'
            . '<fonts count="5">'
            . '<font><sz val="11"/><color rgb="FF1A0A12"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="18"/><color rgb="FFE8185A"/><name val="Calibri"/></font>'
            . '<font><sz val="11"/><color rgb="FF7A4060"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FF7A4060"/><name val="Calibri"/></font>'
            . '</fonts>'
            . '<fills count="5">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFFFF2F8"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE8185A"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFFFF7FB"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FFF6C9DA"/></left><right style="thin"><color rgb="FFF6C9DA"/></right><top style="thin"><color rgb="FFF6C9DA"/></top><bottom style="thin"><color rgb="FFF6C9DA"/></bottom><diagonal/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="9">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="4" fillId="2" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyFont="1"/>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"/>'
            . '<xf numFmtId="0" fontId="3" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyFont="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"/>'
            . '<xf numFmtId="0" fontId="0" fillId="4" borderId="1" xfId="0" applyFill="1" applyBorder="1"/>'
            . '<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1"/>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }
}
