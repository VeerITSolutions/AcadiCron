<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    use HasFactory;

    protected $table = 'student_session';

    protected $fillable = [
        'student_id',
        'section_id',
        'session_id',
        'class_id',
        'route_id',
        'hostel_room_id',
        'vehroute_id',
        'is_alumni'
    ];
}
