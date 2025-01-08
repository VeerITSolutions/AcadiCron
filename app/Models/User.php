<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{


    use HasFactory;

    use HasApiTokens;

   public function myClasses()
    {
        return $this->hasMany(ClassModel::class); // Adjust this based on your relationship
    }
}
