<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectGroups extends Model
{
    use HasFactory;
    protected $fillable = ['name','description', 'session_id'];
}
