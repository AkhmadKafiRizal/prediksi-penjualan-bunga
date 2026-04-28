<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = DB::table('penjualans')
            ->leftJoin('products', 'penjualans.product_id', '=', 'products.id')
            ->select(
                'penjualans.id',
                'penjualans.product_id',
                'products.nama_bunga',
                'penjualans.tanggal',
                'penjualans.jumlah',
                'penjualans.harga',
                'penjualans.promo'
            )
            ->orderByDesc('penjualans.tanggal')
            ->orderBy('penjualans.product_id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('penjualans.tanggal', 'like', "%{$search}%")
                    ->orWhere('penjualans.product_id', 'like', "%{$search}%")
                    ->orWhere('products.nama_bunga', 'like', "%{$search}%")
                    ->orWhere('penjualans.jumlah', 'like', "%{$search}%")
                    ->orWhere('penjualans.harga', 'like', "%{$search}%")
                    ->orWhere('penjualans.promo', 'like', "%{$search}%");
            });
        }

        $rows = $query->paginate(25)->withQueryString();

        $totalData = DB::table('penjualans')->count();

        $totalProduk = DB::table('penjualans')
            ->distinct('product_id')
            ->count('product_id');

        $firstDate = DB::table('penjualans')->min('tanggal');
        $lastDate  = DB::table('penjualans')->max('tanggal');

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

        DB::beginTransaction();

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

                $isDuplicate = DB::table('penjualans')
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

                DB::table('penjualans')->insert([
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

            DB::commit();

            file_put_contents($this->timeFile, date('d-m-Y H:i:s'));

            return redirect()->route('sales')
                ->with('success', "Import CSV berhasil ke database. Data masuk: {$imported}. Duplikat dilewati: {$skippedDuplicate}.");

        } catch (\Exception $e) {
            fclose($handle);

            DB::rollBack();

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

        $exists = DB::table('penjualans')->where('id', $id)->exists();

        if (!$exists) {
            return redirect()->route('sales')->with('error', 'Data tidak ditemukan.');
        }

        DB::table('penjualans')
            ->where('id', $id)
            ->update([
                'product_id' => $request->product_id,
                'tanggal'    => $request->tanggal,
                'jumlah'     => $request->jumlah,
                'harga'      => $request->harga,
                'promo'      => $request->promo,
                'updated_at' => now(),
            ]);

        return redirect()->route('sales')
            ->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $exists = DB::table('penjualans')->where('id', $id)->exists();

        if (!$exists) {
            return redirect()->route('sales')->with('error', 'Data tidak ditemukan.');
        }

        DB::table('penjualans')->where('id', $id)->delete();

        return redirect()->route('sales')
            ->with('success', 'Data penjualan berhasil dihapus.');
    }
}