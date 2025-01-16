<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMarksheets extends Model
{
    use HasFactory;

    protected $table = 'template_marksheets';

    public $timestamps = false;

    protected $fillable = [
        'template',
        'heading',
        'title',
        'left_logo',
        'right_logo',
        'exam_name',
        'school_name',
        'exam_center',
        'left_sign',
        'middle_sign',
        'right_sign',
        'exam_session',
        'is_name',
        'is_father_name',
        'is_mother_name',
        'is_dob',
        'is_admission_no',
        'is_roll_no',
        'is_photo',
        'is_division',
        'is_customfield',
        'background_img',
        'date',
        'is_class',
        'is_teacher_remark',
        'is_section',
        'content',
        'content_footer',
    ];
}
