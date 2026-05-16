<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $primaryKey = '_id';

    protected $fillable = [
        'nama_bunga',
        'satuan',
        'harga_jual',
        'stok_saat_ini',
        'stok_minimum',
        'is_active',
    ];

    protected $casts = [
        'harga_jual'    => 'float',
        'stok_saat_ini' => 'integer',
        'stok_minimum'  => 'integer',
        'is_active'     => 'integer',
    ];
}