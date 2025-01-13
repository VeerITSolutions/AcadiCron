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




public function getSubjectGroupClassSectionsId($class_id, $section_id, $subject_group_id, $current_session)
{
    $result = DB::table('subject_group_class_sections')
        ->join('class_sections', 'class_sections.id', '=', 'subject_group_class_sections.class_section_id')
        ->join('subject_groups', 'subject_groups.id', '=', 'subject_group_class_sections.subject_group_id')
        ->where('class_sections.class_id', $class_id)
        ->where('class_sections.section_id', $section_id)
        ->where('subject_groups.id', $subject_group_id)
        ->where('subject_groups.session_id', $current_session)
        ->orderBy('subject_groups.id', 'DESC')
        ->select('subject_groups.name', 'subject_group_class_sections.*')
        ->first();

        return $result ? $result->id : null; // Return the ID if found
}
}
