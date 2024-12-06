<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectGroupClassSections extends Model
{
    use HasFactory;

    protected $table = 'subject_group_class_sections';

    public function subjectGroup()
    {
        return $this->belongsTo(SubjectGroups::class, 'subject_group_id');
    }

    public function classSection()
    {
        return $this->belongsTo(ClassSections::class, 'class_section_id');
    }
}
