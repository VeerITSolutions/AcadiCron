<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['class_id', 'section_id', 'homework_date', 'submit_date', 'description', 'subject_id'];

    public function class()
        {
            return $this->belongsTo(ClassModel::class, 'class_id');
        }

        public function section()
        {
            return $this->belongsTo(Section::class, 'section_id');
        }

        public function subjectGroupSubject()
        {
            return $this->belongsTo(SubjectGroupSubject::class, 'subject_group_subject_id');
        }

        public function createdBy()
        {
            return $this->belongsTo(Staff::class, 'created_by');
        }

        public function assignments()
        {
            return $this->hasMany(SubmitAssignment::class, 'homework_id');
        }
}
