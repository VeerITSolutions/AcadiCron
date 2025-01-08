<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTimetable extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'subject_timetable';

    protected $fillable = [
        'day',
        'class_id',
        'section_id',
        'subject_group_id',
        'subject_group_subject_id',
        'staff_id',
        'time_from',
        'time_to',
        'start_time',
        'end_time',
        'room_no',
        'session_id',
        'created_at',
    ];

    public function getSubjectByClassandSectionDay($class_id, $section_id, $day)
{
    $subject_condition = "";

    // Get the current user data
    $userdata = auth()->user();
    $role_id = $userdata->role_id;

    // Check if the user is a class teacher
    if ($role_id == 2 && $userdata->class_teacher == 'yes') {
        // Get the classes assigned to the teacher
        $my_classes = $userdata->myClasses();

        // Check if the class is assigned to the teacher
        if (!empty($my_classes) && in_array($class_id, $my_classes)) {
            $subject_condition = ""; // No filter needed
        } else {
            // Get the subjects assigned to the teacher for the specific class
            $my_subjects = $userdata->mySubjects($class_id, $section_id);
            $subject_condition = " AND subject_group_subjects.id IN (" . $my_subjects['subject'] . ")";
        }
    }

    // Add condition to check for active staff
    $subject_condition .= " AND staff.is_active = 1 ORDER BY subject_timetable.start_time ASC";

    // Build the query
    $query = SubjectTimetable::join('subject_group_subjects', 'subject_timetable.subject_group_subject_id', '=', 'subject_group_subjects.id')
        ->join('subjects', 'subject_group_subjects.subject_id', '=', 'subjects.id')
        ->join('staff', 'staff.id', '=', 'subject_timetable.staff_id')
        ->where('subject_timetable.class_id', $class_id)
        ->where('subject_timetable.section_id', $section_id)
        ->where('subject_timetable.day', $day)
        ->where('subject_timetable.session_id', $this->current_session)
        ->whereRaw($subject_condition)
        ->select('subject_group_subjects.subject_id', 'subjects.name as subject_name', 'subjects.code', 'subjects.type', 'staff.name', 'staff.surname', 'staff.employee_id', 'subject_timetable.*')
        ->get();

    return $query;
}
}
