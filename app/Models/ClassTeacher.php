<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTeacher extends Model
{
    use HasFactory;

    protected $table = 'class_teacher';

    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'staff_id',
        'section_id',
        'session_id',
    ];

    

}
