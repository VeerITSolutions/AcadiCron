<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmitAssignment extends Model
{
    use HasFactory;
    protected $table = 'submit_assignment';

    public function homework()
{
    return $this->belongsTo(Homework::class, 'homework_id');
}
}
