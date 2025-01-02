<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $table  = 'expenses';
    public $timestamps = false;

    protected $fillable = [
        'exp_head_id',
        'name',
        'invoice_no',
        'date',
        'amount',
        'documents',
        'note',
        'is_active',
        'is_deleted',
    ];
    
}
