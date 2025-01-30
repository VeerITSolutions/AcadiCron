<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRating extends Model
{
    use HasFactory;
    protected $table = 'staff_rating';
    public $timestamps = false;
    protected $fillable = [
        'staff_id',
        'comment',
        'rate',
        'user_id',
        'role',
        'status',
        'entrydt',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * Get the user who gave the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
