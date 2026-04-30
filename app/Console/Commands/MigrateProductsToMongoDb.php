<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateProductsToMongoDb extends Command
{
    protected $signature = 'products:migrate-to-mongodb';

    protected $description = 'Migrasi data products dari MySQL ke MongoDB';

    public function handle()
    {
        $this->info('Mengambil data products dari MySQL...');

        $products = DB::connection('mysql')
            ->table('products')
            ->orderBy('id')
            ->get();

        $mysqlCount = $products->count();

        $this->info('Jumlah data products di MySQL: ' . $mysqlCount);

        if ($mysqlCount === 0) {
            $this->error('Data products di MySQL kosong. Migrasi dibatalkan.');
            return self::FAILURE;
        }

        $documents = $products->map(function ($product) {
            return [
                'id' => (int) $product->id,
                'nama_bunga' => $product->nama_bunga,
                'satuan' => $product->satuan,
                'harga_jual' => (float) $product->harga_jual,
                'stok_minimum' => (int) $product->stok_minimum,
                'is_active' => (int) $product->is_active,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        })->toArray();

        $this->info('Menghapus isi collection products lama di MongoDB agar tidak duplikat...');

        DB::connection('mongodb')
            ->table('products')
            ->delete();

        $this->info('Memasukkan data products ke MongoDB...');

        DB::connection('mongodb')
            ->table('products')
            ->insert($documents);

        $mongoCount = DB::connection('mongodb')
            ->table('products')
            ->count();

        $this->info('Jumlah data products di MongoDB: ' . $mongoCount);

        if ($mysqlCount !== $mongoCount) {
            $this->error('TIDAK VALID: jumlah data MySQL dan MongoDB berbeda.');
            return self::FAILURE;
        }

        $this->info('VALID: migrasi products selesai dan jumlah data sama.');

        return self::SUCCESS;
    }
}