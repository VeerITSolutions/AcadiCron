<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','type','is_active'];

    protected $table = 'subjects';

    public function subjectGroups()
    {
        return $this->belongsToMany(SubjectGroups::class, 'subject_group_subjects', 'subject_id', 'subject_group_id');
    }
}
