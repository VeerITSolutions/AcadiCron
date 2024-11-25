<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDoc extends Model
{
    use HasFactory;

    protected $table = 'student_doc';
    public $timestamps = false;


    protected $fillable = ['student_id',
'title',
'doc'];
}
