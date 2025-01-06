<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    use HasFactory;
    protected $table = 'item_stock';

    protected $fillable = [
        'item_id',
        'supplier_id',
        'symbol',
        'store_id',
        'quantity',
        'purchase_price',
        'date',
        'attachment',
        'description',
        'is_active',
    ];
    
}
