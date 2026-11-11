<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class InventorySnapshot extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'inventory_snapshots';

    protected $fillable = [
        'total_stock',
        'inventory_value',
        'product_count',
        'recorded_at',
    ];

    protected $casts = [
        'total_stock' => 'integer',
        'inventory_value' => 'float',
        'product_count' => 'integer',
        'recorded_at' => 'datetime',
    ];
}
