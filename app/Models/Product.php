<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'products';

    protected $fillable = [
        'name',
        'brand',
        'category',
        'size',
        'color',
        'price',
        'quantity',
        'description',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];
}
