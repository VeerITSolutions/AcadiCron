<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    use HasFactory;

    protected $table = 'grades';

    public $timestamps = false;

    protected $fillable = [
        'exam_type',
        'name',
        'point',
        'mark_from',
        'mark_upto',
        'description',
        'is_active',
    ];
}
