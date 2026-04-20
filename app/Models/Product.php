<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'nama_bunga',
    'satuan',
    'harga_jual',
    'stok_minimum',
    'is_active'
];
}
