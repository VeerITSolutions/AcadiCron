<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classwork extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'classwork';
    protected $fillable = ['class_id', 'section_id', 'classwork_date', 'submit_date', 'description', 'subject_id'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }

    public function subjectGroupSubject()
    {
        return $this->belongsTo(SubjectGroupSubjects::class, 'subject_group_subject_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    public function assignments()
    {
        return $this->hasMany(SubmitAssignment::class, 'classwork_id');
    }

    public function getStudents($id)
    {
        return DB::table('student_session')
            ->selectRaw('
                    IFNULL(classwork_evaluation.id, 0) as classwork_evaluation_id,
                    student_session.*,
                    students.firstname,
                    students.middlename,
                    students.lastname,
                    students.admission_no
                ')
            ->joinSub(
                DB::table('classwork')
                    ->select('id as classwork_id', 'class_id', 'section_id', 'session_id', 'description')
                    ->where('id', '=', $id),
                'classwork',
                function ($join) {
                    $join->on('classwork.class_id', '=', 'student_session.class_id')
                        ->on('classwork.section_id', '=', 'student_session.section_id')
                        ->on('classwork.session_id', '=', 'student_session.session_id');
                }
            )
            ->join('students', function ($join) {
                $join->on('students.id', '=', 'student_session.student_id')
                    ->where('students.is_active', '=', 'yes');
            })
            ->leftJoin('classwork_evaluation', function ($join) use ($id) {
                $join->on('classwork_evaluation.student_session_id', '=', 'student_session.id')
                    ->on('classwork_evaluation.classwork_id', '=', DB::raw($id))
                    ->where('students.is_active', '=', 'yes');
            })
            ->orderBy('students.id', 'desc')
            ->get()
            ->toArray();
    }
}
