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
    protected $fillable = ['date', 'document_file', 'leave_from', 'leave_to', 'leave_type_id'];
    
}
