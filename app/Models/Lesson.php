<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    use HasFactory;
    protected $table = "lesson";
    public $timestamps = false;

    protected $fillable = ['session_id', 'subject_group_subject_id', 'subject_group_class_sections_id','name'];


    public function getSubjectGroupClassSectionsId($classId, $sectionId, $subjectGroupId , $current_session)
{
    $result = DB::table('subject_group_class_sections')
        ->join('class_sections', 'class_sections.id', '=', 'subject_group_class_sections.class_section_id')
        ->join('subject_groups', 'subject_groups.id', '=', 'subject_group_class_sections.subject_group_id')
        ->select('subject_groups.name', 'subject_group_class_sections.*')
        ->where('class_sections.class_id', $classId)
        ->where('class_sections.section_id', $sectionId)
        ->where('subject_groups.id', $subjectGroupId)
        ->where('subject_groups.session_id', $current_session)
        ->orderBy('subject_groups.id', 'desc')
        ->first();

    return (array) $result; // Convert the result to an array, similar to `row_array()` in CodeIgniter
}
}
