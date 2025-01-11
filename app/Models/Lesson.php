<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = "lesson";
    public $timestamps = false;

    protected $fillable = ['session_id', 'subject_group_subject_id', 'subject_group_class_sections_id','name'];
}
