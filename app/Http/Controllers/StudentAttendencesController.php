<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAttendencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // Retrieve the 'id' from the request if it exists
        $id = $request->input('id');

        // Start building the query on the student_attendences table
        $query = DB::table('student_attendences');

        // If an ID is provided, filter the results by ID
        if ($id !== null) {
            $query->where('id', $id);
        } else {
            // If no ID is provided, order the results by ID
            $query->orderBy('id');
        }

        // Execute the query and return the result
        return $id !== null ? $query->first() : $query->get();
    }



    public function searchAttendenceClassSection(Request $request, $class_id = 1, $section_id = 1, $date = null)
    {
        // Set $date to today's date if no value is provided
        $date = $date ?? date('Y-m-d');

    $currentSession = '2024-25'; // Assuming this is a class property.

    $results = DB::table('students')
        ->select(
            'student_sessions.attendence_id',
            'student_sessions.attendence_dt',
            'students.firstname',
            'students.middlename',
            'students.lastname',
            'student_sessions.date',
            'student_sessions.remark',
            'student_sessions.biometric_attendence',
            'students.roll_no',
            'students.admission_no',
            'students.id as std_id',
            'students.lastname',
            'student_sessions.attendence_type_id',
            'student_sessions.id as student_session_id',
            'attendence_type.type as att_type',
            'attendence_type.key_value as key'
        )
        ->joinSub(
            DB::table('student_session')
                ->leftJoin('student_attendences', function ($join) use ($date) {
                    $join->on('student_attendences.student_session_id', '=', 'student_session.id')
                         ->where('student_attendences.date', '=', $date);
                })
                ->select(
                    'student_session.id',
                    'student_session.student_id',
                    DB::raw("IFNULL(student_attendences.date, 'xxx') as date"),
                    DB::raw("IFNULL(student_attendences.created_at, 'xxx') as attendence_dt"),
                    'student_attendences.remark',
                    'student_attendences.biometric_attendence',
                    DB::raw("IFNULL(student_attendences.id, 0) as attendence_id"),
                    'student_attendences.attendence_type_id'
                )
                ->where('student_session.session_id', '=', $currentSession)
                ->where('student_session.class_id', '=', $class_id)
                ->where('student_session.section_id', '=', $section_id),
            'student_sessions',
            'student_sessions.student_id',
            '=',
            'students.id'
        )
        ->leftJoin('attendence_type', 'attendence_type.id', '=', 'student_sessions.attendence_type_id')
        ->where('students.is_active', '=', 'yes')
        ->orderBy('students.id', 'desc')
        ->get();

    return $results;
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
