<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentFor extends Model
{
    use HasFactory;
    protected $table = "contents";
    protected $fillable = ['title','type', 'is_public', 'class_id', 'cls_sec_id', 'role', 'note'];
}
