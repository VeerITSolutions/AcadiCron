<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTimeline extends Model
{
    use HasFactory;

    protected $fillable = [

'student_id',
'title',
'timeline_date',
'description',
'document',
'status',
'date',
    ];
}
