<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $filterStatus = $request->query('status', '');
        $filterStok = $request->query('stok', '');
        $perPage = 10;
        $currentPage = max(1, (int) LengthAwarePaginator::resolveCurrentPage());

        $allProducts = Product::orderBy('id')->get();
        $totalProducts = $allProducts->count();
        $totalLowStock = $allProducts
            ->filter(fn ($product) => $this->isActive($product) && $this->isLowStock($product))
            ->count();
        $totalInactive = $allProducts->filter(fn ($product) => ! $this->isActive($product))->count();

        $filteredProducts = $allProducts
            ->when($search !== '', function ($products) use ($search) {
                $keyword = mb_strtolower($search);

                return $products->filter(function ($product) use ($keyword) {
                    return str_contains(mb_strtolower((string) ($product->nama_bunga ?? '')), $keyword)
                        || str_contains(mb_strtolower((string) ($product->satuan ?? '')), $keyword)
                        || str_contains((string) ($product->id ?? ''), $keyword);
                });
            })
            ->when($filterStatus === 'aktif', fn ($products) => $products->filter(fn ($product) => $this->isActive($product)))
            ->when($filterStatus === 'nonaktif', fn ($products) => $products->filter(fn ($product) => ! $this->isActive($product)))
            ->when($filterStok === 'perlu_restock', fn ($products) => $products->filter(fn ($product) => $this->isActive($product) && $this->isLowStock($product)))
            ->when($filterStok === 'habis', fn ($products) => $products->filter(fn ($product) => (int) ($product->stok_saat_ini ?? 0) <= 0))
            ->when($filterStok === 'aman', fn ($products) => $products->filter(fn ($product) => ! $this->isLowStock($product)))
            ->map(function ($product) {
                $product->updated_at_label = $this->formatDateTimeLabel($product->updated_at ?? null);

                return $product;
            })
            ->values();

        $products = new LengthAwarePaginator(
            $filteredProducts->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $filteredProducts->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('products.index', compact(
            'products',
            'totalProducts',
            'totalLowStock',
            'totalInactive',
            'search',
            'filterStatus',
            'filterStok'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bunga'    => 'required|string|max:255',
            'satuan'        => 'required|in:tangkai',
            'harga_jual'    => 'required|numeric|min:5000',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:1',
        ]);

        if ($this->productNameExists($validated['nama_bunga'])) {
            return back()
                ->withInput()
                ->with('error', 'Nama produk sudah ada. Gunakan nama bunga yang berbeda agar data produk, mobile kasir, dan prediksi tidak membingungkan.');
        }

        $nextId = ((int) (Product::max('id') ?? Product::max('_id') ?? 0)) + 1;

        $validated['_id'] = $nextId;
        $validated['id'] = $nextId;
        $validated['is_active'] = 1;

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('_id', (int) $id)->firstOrFail();

        $validated = $request->validate([
            'nama_bunga'    => 'required|string|max:255',
            'satuan'        => 'required|in:tangkai',
            'harga_jual'    => 'required|numeric|min:5000',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:1',
        ]);

        if ($this->productNameExists($validated['nama_bunga'], (int) ($product->id ?? $product->_id ?? $id))) {
            return back()
                ->withInput()
                ->with('error', 'Nama produk sudah dipakai produk lain. Perubahan dibatalkan agar data produk tetap mudah ditelusuri.');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::where('_id', (int) $id)->firstOrFail();
        $product->update(['is_active' => 0]);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga dinonaktifkan');
    }

    public function activate($id)
    {
        $product = Product::where('_id', (int) $id)->firstOrFail();
        $product->update(['is_active' => 1]);

        return redirect()->route('products.index')
            ->with('success', 'Produk bunga berhasil diaktifkan kembali');
    }

    public function export()
    {
        $products = Product::orderBy('id')->get();
        $activeCount = $products->filter(fn ($product) => $this->isActive($product))->count();
        $inactiveCount = $products->count() - $activeCount;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Produk');

        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'FloraPredict - Daftar Produk Bunga');
        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A2', 'Master data produk untuk stok aplikasi kasir, prediksi, dan Asisten AI.');

        $sheet->setCellValue('A4', 'Total Produk');
        $sheet->setCellValue('B4', $products->count());
        $sheet->setCellValue('C4', 'Aktif');
        $sheet->setCellValue('D4', $activeCount);
        $sheet->setCellValue('E4', 'Nonaktif');
        $sheet->setCellValue('F4', $inactiveCount);
        $sheet->setCellValue('G4', 'Diexport Pada');
        $sheet->setCellValue('H4', now()->format('d M Y, H:i') . ' WIB');

        $headers = [
            'No',
            'ID Produk',
            'Nama Bunga',
            'Satuan',
            'Harga Jual (Rp)',
            'Stok Saat Ini',
            'Stok Minimum',
            'Status Stok',
            'Status Produk',
            'Terakhir Diperbarui',
            'Keterangan',
        ];

        $sheet->fromArray($headers, null, 'A6');

        $row = 7;
        foreach ($products as $index => $product) {
            $stokSaatIni = (int) ($product->stok_saat_ini ?? 0);
            $stokMinimum = (int) ($product->stok_minimum ?? 0);
            $isActive = $this->isActive($product);
            $isLowStock = $stokSaatIni <= $stokMinimum;
            $statusStok = $stokSaatIni <= 0 ? 'Habis' : ($isLowStock ? 'Stok Rendah' : 'Aman');
            $keterangan = ! $isActive
                ? 'Produk nonaktif, tidak tampil di mobile kasir'
                : ($isLowStock ? 'Perlu restock' : 'Stok aman');

            $sheet->fromArray([
                $index + 1,
                $product->id ?? $product->_id ?? '',
                $product->nama_bunga ?? '-',
                $product->satuan ?? 'tangkai',
                (int) ($product->harga_jual ?? 0),
                $stokSaatIni,
                $stokMinimum,
                $statusStok,
                $isActive ? 'Aktif' : 'Nonaktif',
                $this->formatDateTimeLabel($product->updated_at ?? null),
                $keterangan,
            ], null, 'A' . $row);

            $row++;
        }

        $lastRow = max(6, $row - 1);
        $pink = 'E8185A';
        $lightPink = 'FFF2F8';

        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => $pink]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '7A4060']],
        ]);
        $sheet->getStyle('A4:H4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '7A2A4A']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $lightPink]],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'F8BBD0']]],
        ]);
        $sheet->getStyle('A6:K6')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $pink]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle("A6:K{$lastRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'F8BBD0']]],
        ]);
        if ($lastRow >= 7) {
            $sheet->getStyle("A7:K{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("E7:E{$lastRow}")->getNumberFormat()->setFormatCode('"Rp" #,##0');
            $sheet->getStyle("A7:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F7:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H7:J{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->freezePane('A7');
        $sheet->setAutoFilter("A6:K{$lastRow}");

        $exportDir = storage_path('app/exports');
        if (! is_dir($exportDir)) {
            mkdir($exportDir, 0775, true);
        }

        $filename = 'daftar-produk-bunga_' . now()->format('Ymd_His') . '.xlsx';
        $path = $exportDir . DIRECTORY_SEPARATOR . $filename;

        (new Xlsx($spreadsheet))->save($path);

        return response()
            ->download($path, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend(true);
    }

    private function isActive($product): bool
    {
        return (int) ($product->is_active ?? 1) === 1;
    }

    private function isLowStock($product): bool
    {
        return (int) ($product->stok_saat_ini ?? 0) <= (int) ($product->stok_minimum ?? 0);
    }

    private function productNameExists(string $name, ?int $ignoreId = null): bool
    {
        $normalizedName = $this->normalizeProductName($name);

        return Product::all()->contains(function ($product) use ($normalizedName, $ignoreId) {
            $productId = (int) ($product->id ?? $product->_id ?? 0);

            if ($ignoreId !== null && $productId === $ignoreId) {
                return false;
            }

            return $this->normalizeProductName((string) ($product->nama_bunga ?? '')) === $normalizedName;
        });
    }

    private function normalizeProductName(string $name): string
    {
        $normalized = preg_replace('/\s+/', ' ', $name) ?? '';

        return mb_strtolower(trim($normalized));
    }

    private function formatDateTimeLabel($value): string
    {
        if (empty($value)) {
            return 'Belum tercatat';
        }

        try {
            if ($value instanceof UTCDateTime) {
                $date = Carbon::instance($value->toDateTime());
            } elseif ($value instanceof \DateTimeInterface) {
                $date = Carbon::instance($value);
            } else {
                $date = Carbon::parse($value);
            }

            $date->timezone('Asia/Jakarta');
            $months = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Agu',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des',
            ];

            return $date->format('d') . ' ' . $months[(int) $date->format('n')] . ' ' . $date->format('Y H:i');
        } catch (\Throwable $e) {
            return 'Belum tercatat';
        }
    }
}
