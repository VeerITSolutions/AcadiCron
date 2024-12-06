<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectGroupSubjects extends Model
{
    use HasFactory;

    protected $fillable = ['subject_group_id','session_id', 'subject_id'];
}
