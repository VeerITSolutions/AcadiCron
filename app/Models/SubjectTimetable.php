<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTimetable extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'subject_timetable';

    protected $fillable = [
        'day',
        'class_id',
        'section_id',
        'subject_group_id',
        'subject_group_subject_id',
        'staff_id',
        'time_from',
        'time_to',
        'start_time',
        'end_time',
        'room_no',
        'session_id',
        'created_at',
    ];
}
