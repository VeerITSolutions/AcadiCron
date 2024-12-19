<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSections extends Model
{
    use HasFactory;

    protected $table = 'class_sections';

    protected $fillable = [
        'class_id',
        'section_id',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }

    public function subjectGroupClassSections()
    {
        return $this->hasMany(SubjectGroupClassSections::class, 'class_section_id');
    }
}
