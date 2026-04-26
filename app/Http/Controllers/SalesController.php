<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    protected string $csvFile;
    protected string $timeFile;

    public function __construct()
    {
        $this->csvFile = base_path('dataset/cleaned_flower_sales_dataset.csv');
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
            'dataset' => 'required|mimes:csv,txt'
        ]);

        $request->file('dataset')->move(
            base_path('dataset'),
            'cleaned_flower_sales_dataset.csv'
        );

        file_put_contents($this->timeFile, date('d-m-Y H:i:s'));

        return redirect()->route('sales')
            ->with('success', 'Dataset berhasil diupload. Catatan: data utama sistem tetap menggunakan tabel penjualans di database.');
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