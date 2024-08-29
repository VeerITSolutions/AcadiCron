<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolHouses extends Model
{
    use HasFactory;
    public $timestamps = false;

     // Specify the fillable fields
     protected $fillable = ['house_name','description'];


}
