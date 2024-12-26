<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeHead extends Model
{
    use HasFactory;

    protected $table  = 'income_head';
    protected $fillable = ['name', 'description'];
}
