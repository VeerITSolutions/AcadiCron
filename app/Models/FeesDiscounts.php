<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesDiscounts extends Model
{
    use HasFactory;
    protected $fillable = ['name','code','amount','description','is_active'];
}
