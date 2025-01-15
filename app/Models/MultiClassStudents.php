<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiClassStudents extends Model
{
    use HasFactory;

    protected $table = 'multi_class_students';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'student_session_id',
    ];
}
