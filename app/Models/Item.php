<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';

    public $timestamps = false;
    

    protected $fillable = [
        'item_category_id',
        'name',
        'unit',
        'item_photo',
        'description',
        'created_at',
        'updated_at',
        'item_store_id',
        'item_supplier_id',
        'quantity',
    ];
}
