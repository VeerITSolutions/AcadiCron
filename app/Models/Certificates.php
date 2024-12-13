<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;

    protected $table  = 'certificates';
    public $timestamps = false;

    // Specify the fillable fields
    protected $fillable = [
        'certificate_name',
        'certificate_text',
        'left_header',
        'center_header',
        'right_header',
        'left_footer',
        'right_footer',
        'center_footer',
        'background_image',
        'created_for',
        'status',
        'header_height',
        'content_height',
        'footer_height',
        'content_width',
        'enable_student_image',
        'enable_image_height',
    ];


}
