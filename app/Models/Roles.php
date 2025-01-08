<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';
  /*   protected $timestamps = false; */

    // If you have other attributes you can define them here
    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'is_system',
        'is_superadmin',
        'created_at',
        'updated_at',
    ];
}
