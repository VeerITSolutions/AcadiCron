<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStore extends Model
{
    use HasFactory;

    protected $table = 'item_store';

    public $timestamps = false;

    protected $fillable = [
        'item_store',
        'code',
        'description',
        
    ];
}
