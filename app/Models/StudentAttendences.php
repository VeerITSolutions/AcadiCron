<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendences extends Model
{
    use HasFactory;

    protected $table = 'student_attendences';
    protected $fillable = [
        'student_session_id',
        'date',
        'attendence_type_id',
        'remark',
        'biometric_attendence',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function attendanceType()
    {
        return $this->belongsTo(AttendenceType::class, 'attendence_type_id');
    }
}
