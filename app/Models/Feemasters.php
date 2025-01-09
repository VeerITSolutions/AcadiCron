<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feemasters extends Model
{
    use HasFactory;

    protected $table  = 'student_fees_master';
    public $timestamps = false;

    protected $fillable = [
        'is_system',
        'student_session_id',
        'fee_session_group_id',
        'amount',
        'is_active',
        'created_at',
    ];
}
