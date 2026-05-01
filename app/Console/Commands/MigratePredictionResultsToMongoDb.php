<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigratePredictionResultsToMongoDb extends Command
{
    protected $signature = 'prediction-results:migrate-to-mongodb';

    protected $description = 'Migrasi data prediction_results dari MySQL ke MongoDB';

    public function handle()
    {
        $this->info('Mengambil data prediction_results dari MySQL...');

        $results = DB::connection('mysql')
            ->table('prediction_results')
            ->orderBy('id')
            ->get();

        $mysqlCount = $results->count();

        $this->info('Jumlah data prediction_results di MySQL: ' . $mysqlCount);

        if ($mysqlCount === 0) {
            $this->error('Data prediction_results di MySQL kosong. Migrasi dibatalkan.');
            return self::FAILURE;
        }

        $documents = $results->map(function ($result) {
            return [
                'id' => (int) $result->id,
                'tanggal' => $result->tanggal,
                'product_id' => (int) $result->product_id,
                'actual_sales' => (int) $result->actual_sales,
                'predicted_sales' => (int) $result->predicted_sales,
                'mae' => is_null($result->mae) ? null : (float) $result->mae,
                'rmse' => is_null($result->rmse) ? null : (float) $result->rmse,
                'validation_mae' => is_null($result->validation_mae) ? null : (float) $result->validation_mae,
                'validation_rmse' => is_null($result->validation_rmse) ? null : (float) $result->validation_rmse,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at,
            ];
        })->toArray();

        $this->info('Menghapus isi collection prediction_results lama di MongoDB agar tidak duplikat...');

        DB::connection('mongodb')
            ->table('prediction_results')
            ->delete();

        $this->info('Memasukkan data prediction_results ke MongoDB...');

        DB::connection('mongodb')
            ->table('prediction_results')
            ->insert($documents);

        $mongoCount = DB::connection('mongodb')
            ->table('prediction_results')
            ->count();

        $this->info('Jumlah data prediction_results di MongoDB: ' . $mongoCount);

        if ($mysqlCount !== $mongoCount) {
            $this->error('TIDAK VALID: jumlah data MySQL dan MongoDB berbeda.');
            return self::FAILURE;
        }

        $this->info('VALID: migrasi prediction_results selesai dan jumlah data sama.');

        return self::SUCCESS;
    }
}