<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'products';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'nama_bunga',
        'satuan',
        'harga_jual',
        'stok_minimum',
        'is_active',
    ];

    protected $casts = [
        'id' => 'integer',
        'harga_jual' => 'float',
        'stok_minimum' => 'integer',
        'is_active' => 'integer',
    ];
}