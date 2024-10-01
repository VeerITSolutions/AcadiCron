<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feetype extends Model
{
    use HasFactory;

    protected $table = 'feetype';

    protected $fillable = ['is_system','type','feecategory_id','code','is_active','description'];

    
    

}
