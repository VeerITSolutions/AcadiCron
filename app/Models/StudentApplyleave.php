<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplyleave extends Model
{
    use HasFactory;
    protected $table = 'student_applyleave';
    public $timestamps = false;

    protected $fillable =['student_session_id','from_date','to_date','apply_date','created_at','docs','reason','status','approve_by','request_type',];
}
