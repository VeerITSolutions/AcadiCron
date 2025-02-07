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

    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'lang_id',
        'department',
        'designation',
        'qualification',
        'work_exp',
        'name',
        'surname',
        'father_name',
        'mother_name',
        'contact_no',
        'emergency_contact_no',
        'email',
        'dob',
        'marital_status',
        'date_of_joining',
        'date_of_leaving',
        'local_address',
        'permanent_address',
        'note',
        'image',
        'password',
        'gender',
        'account_title',
        'bank_account_no',
        'bank_name',
        'ifsc_code',
        'bank_branch',
        'payscale',
        'basic_salary',
        'epf_no',
        'contract_type',
        'shift',
        'location',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'resume',
        'joining_letter',
        'resignation_letter',
        'other_document_name',
        'other_document_file',
        'user_id',
        'is_active',
        'verification_code',
        'disable_at'
    ];





    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'staff_roles', 'staff_id', 'role_id');
    }

    public function staffLeaveDetails()
    {
        return $this->hasMany(StaffLeaveDetails::class, 'staff_id', 'id');
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }
}
