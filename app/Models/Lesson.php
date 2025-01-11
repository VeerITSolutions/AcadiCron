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


    public function getSubjectGroupClassSectionsId($classId, $sectionId, $subjectGroupId, $currentSession)
{
    $result = DB::table('subject_group_class_sections')
        ->join('class_sections', 'class_sections.id', '=', 'subject_group_class_sections.class_section_id')
        ->join('subject_groups', 'subject_groups.id', '=', 'subject_group_class_sections.subject_group_id')
        ->where('class_sections.class_id', $classId)
        ->where('class_sections.section_id', $sectionId)
        ->where('subject_groups.id', $subjectGroupId)
        ->where('subject_groups.session_id', $currentSession)
        ->orderBy('subject_groups.id', 'desc')
        ->first(); // Ensure to get only the first record

    // Return the subject_group_class_sections_id (or equivalent)
    return $result ? $result->id : null; // Return the ID if found
}
}
