<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Staff  extends Authenticatable
{
    use HasFactory;

    use HasApiTokens;


    public function roles()
{
    return $this->belongsToMany(Roles::class, 'staff_roles', 'staff_id', 'role_id');
}

public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }
}
