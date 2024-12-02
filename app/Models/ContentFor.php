<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentFor extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = "content_for";
    protected $fillable = ['role','content_id', 'user_id', 'created_at'];
}
