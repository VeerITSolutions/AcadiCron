<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table  = 'income';
    public $timestamps = false;

    protected $fillable = [
        'inc_head_id',
        'name',
        'invoice_no',
        'date',
        'amount',
        'note',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
        'documents',
    ];
    


}
