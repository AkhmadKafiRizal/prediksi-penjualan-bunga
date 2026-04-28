<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PredictionApiController extends Controller
{
    public function index()
    {
        $data = DB::table('prediction_results as pr')
            ->leftJoin('products as p', 'pr.product_id', '=', 'p.id')
            ->select(
                'pr.product_id',
                'p.nama_bunga',
                'pr.predicted_sales'
            )
            ->orderByDesc('pr.created_at')
            ->get();

        // Format ulang untuk mobile (clean JSON)
        $result = $data->map(function ($item) {
            return [
                'product_id'   => $item->product_id,
                'nama_bunga'   => $item->nama_bunga ?? 'Produk #' . $item->product_id,
                'prediction'   => (int) $item->predicted_sales,
            ];
        });

        return response()->json($result);
    }
}