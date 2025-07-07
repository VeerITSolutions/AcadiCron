<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontCmsMediaGallery extends Model
{
    use HasFactory;
    protected $table = 'front_cms_media_gallery';

    protected $fillable = [
        'image',
        'thumb_path',
        'dir_path',
        'img_name',
        'thumb_name',
        'created_at',
        'file_type',
        'file_size',
        'vid_url',
        'vid_title',
    ];

    public $timestamps = false;
}
