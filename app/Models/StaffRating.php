<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRating extends Model
{
    use HasFactory;
    protected $table = 'staff_rating';
    protected $fillable = [
        'staff_id',
        'comment',
        'rate',
        'user_id',
        'role',
        'status',
        'entrydt',
    ];
}
