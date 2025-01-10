<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $table = 'questions';

    public $timestamps = false;
    

    protected $fillable = [
        'staff_id',
        'subject_id',
        'question_type',
        'level',
        'class_id ',
        'section_id',
        'class_section_id',
        'question',
        'opt_a',
        'opt_b',
        'opt_c',
        'opt_d',
        'opt_e',
        'correct',
        'created_at',
        'updated_at',
    ];
}
