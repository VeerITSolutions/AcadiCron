<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDesignation extends Model
{
    use HasFactory;

    protected $table = 'staff_designation';
    public $timestamps = false;

    protected $fillable = ['designation','is_active'];
}
