<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['class_id', 'section_id', 'homework_date', 'submit_date', 'description', 'subject_id'];
}
