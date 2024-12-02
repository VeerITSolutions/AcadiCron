<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'is_public',
        'class_id',
        'cls_sec_id',
        'file',
        'created_by',
        'note',
        'is_active',
        'created_at',
        'updated_at',
        'date',
    ];

}
