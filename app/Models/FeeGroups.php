<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeGroups extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'fee_groups';

    protected $fillable = ['name','is_active','description'];
}
