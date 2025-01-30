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

    protected $table = 'users';

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'childs',
        'role',
        'verification_code',
        'lang_id',
        'is_active'
    ];

    public function myClasses()
    {
        return $this->hasMany(ClassModel::class); // Adjust this based on your relationship
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'user_id');
    }
}
