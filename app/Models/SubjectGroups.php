<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectGroups extends Model
{
    use HasFactory;

    protected $fillable = ['name','description', 'session_id'];

    protected $table = 'subject_groups';

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'subject_group_subjects', 'subject_group_id', 'subject_id');
    }

    public function classSections()
    {
        return $this->hasMany(SubjectGroupClassSections::class, 'subject_group_id');
    }

    public function session()
    {
        return $this->belongsTo(Sessions::class, 'session_id');
    }


}
