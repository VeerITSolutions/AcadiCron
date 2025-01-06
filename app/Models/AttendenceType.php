<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendenceType extends Model
{
    use HasFactory;
    protected $table = 'attendence_type';
    protected $fillable = ['type','key_value','is_active', 'created_at','updated_at'];
}
