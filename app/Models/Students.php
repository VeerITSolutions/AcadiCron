<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Students extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'parent_id',
'admission_no',
'roll_no',
'admission_date',
'firstname',
'middlename',
'lastname',
'rte',
'image',
'mobileno',
'email',
'state',
'city',
'pincode',
'religion',
'cast',
'dob',
'gender',
'current_address',
'permanent_address',
'category_id',
'route_id',
'school_house_id',
'blood_group',
'vehroute_id',
'hostel_room_id',
'adhar_no',
'samagra_id',
'bank_account_no',
'bank_name',
'ifsc_code',
'guardian_is',
'father_name',
'father_phone',
'father_occupation',
'mother_name',
'mother_phone',
'mother_occupation',
'guardian_name',
'guardian_relation',
'guardian_phone',
'guardian_occupation',
'guardian_address',
'guardian_email',
'father_pic',
'mother_pic',
'guardian_pic',
'is_active',
'previous_school',
'height',
'weight',
'measurement_date',
'dis_reason',
'note',
'dis_note',
'app_key',
'parent_app_key',
'disable_at',
    ];


    public function searchByClassSectionWithSession($class_id = null, $section_id = null, $session_id = null)
{
    $query = DB::table('students')
        ->select(
            'classes.id as class_id',
            'student_session.id as student_session_id',
            'students.id',
            'classes.class',
            'sections.id as section_id',
            'sections.section',
            'students.admission_no',
            'students.roll_no',
            'students.admission_date',
            'students.firstname',
            'students.middlename',
            'students.lastname',
            'students.image',
            'students.mobileno',
            'students.email',
            'students.state',
            'students.city',
            'students.pincode',
            'students.religion',
            'students.dob',
            'students.current_address',
            'students.permanent_address',
            DB::raw('IFNULL(students.category_id, 0) as category_id'),
            DB::raw('IFNULL(categories.category, "") as category'),
            'students.adhar_no',
            'students.samagra_id',
            'students.bank_account_no',
            'students.bank_name',
            'students.ifsc_code',
            'students.guardian_name',
            'students.guardian_relation',
            'students.guardian_phone',
            'students.guardian_address',
            'students.is_active',
            'students.created_at',
            'students.updated_at',
            'students.father_name',
            'students.rte',
            'students.gender'
        )
        ->join('student_session', 'student_session.student_id', '=', 'students.id')
        ->join('classes', 'student_session.class_id', '=', 'classes.id')
        ->join('sections', 'sections.id', '=', 'student_session.section_id')
        ->leftJoin('categories', 'students.category_id', '=', 'categories.id')
        ->where('student_session.session_id', $session_id)
        ->where('students.is_active', 'yes');

    if (!is_null($class_id)) {
        $query->where('student_session.class_id', $class_id);
    }

    if (!is_null($section_id)) {
        $query->where('student_session.section_id', $section_id);
    }

    $query->orderBy('students.id');

    return $query->get()->toArray();
}
}
