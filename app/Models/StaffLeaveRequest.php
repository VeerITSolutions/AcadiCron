<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLeaveRequest extends Model
{
    use HasFactory;
    protected $table = 'staff_leave_request';
    public $timestamps = false;

    // Specify the fillable fields
    // protected $fillable = ['house_name','description'];
}
