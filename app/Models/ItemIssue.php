<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemIssue extends Model
{
    use HasFactory;

    protected $table = 'item_issue';

    public $timestamps = false;

    protected $fillable = [
        'issue_type',
        'issue_to',
        'issue_by',
        'issue_date',
        'return_date',
        'item_category_id',
        'item_id',
        'quantity',
        'note',
        'is_returned',
        'is_active'
    ];
    
}
