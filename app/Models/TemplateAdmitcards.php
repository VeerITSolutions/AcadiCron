<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateAdmitcards extends Model
{
    use HasFactory;

    protected $table = 'template_admitcards';

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
        'sign',
        'background_img',
        'is_name',
        'is_father_name',
        'is_mother_name',
        'is_dob',
        'is_admission_no',
        'is_roll_no',
        'is_address',
        'is_gender',
        'is_photo',
        'is_class',
        'is_section',
        'content_footer',
    ];
}
