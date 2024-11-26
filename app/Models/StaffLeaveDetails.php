<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLeaveDetails extends Model
{
    use HasFactory;

    protected $table = 'staff_leave_details';
    protected $fillable = ['staff_id', 'leave_type_id', 'alloted_leave'];
}
