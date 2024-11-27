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
    protected $fillable = ['name','surname','employee_id','id','staff_id','leave_type_id','leave_from','leave_to','leave_days','employee_remark','admin_remark','status','applied_by','document_file','date','type',];
}
