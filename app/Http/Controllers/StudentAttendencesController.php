<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendences;
use App\Models\Students;
use App\Models\StudentSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAttendencesController extends Controller
{




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
                    /*  ->where('student_session.session_id', '=', $currentSession) */
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize pagination variables
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);

        $month = (int) $request->input('month');
        $year = (int) $request->input('year');



        // Initialize the query for retrieving staff attendance
        $query = StudentAttendences::select(
            'student_attendences.*',
            'students.firstname as students_name',
            'students.lastname as students_surname',
            'attendence_type.type as student_attendences_type'
        )
            ->join('student_session', 'student_attendences.student_session_id', '=', 'student_session.id')
            ->join('students', 'student_session.student_id', '=', 'students.id')
            ->leftJoin('attendence_type', 'attendence_type.id', '=', 'student_attendences.attendence_type_id');





        // Apply pagination to the query
        $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Return paginated data with pagination details
        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(), // Current page data
            'current_page' => $paginatedData->currentPage(),
            'per_page' => $paginatedData->perPage(),
            'total' => $paginatedData->total(),
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $attendanceData = json_decode($request->input('attendance_data')); // Assuming JSON input in 'attendance_data'
        $date = $request->input('date');
        $holiday = $request->input('holiday');



        foreach ($attendanceData as $data) {
            // Check if an entry for this student_session_id and date already exists
            $existingEntry = DB::table('student_attendences')
                ->where('student_session_id', $data->id)
                ->where('date', $date)
                ->first();

            // Extract optional fields, handle their absence
            $attendanceType = $data->attendance_type ?? null;
            $attendanceNote = $data->attendance_note ?? '';

            if ($existingEntry) {
                // If entry exists and values differ, update it
                if (
                    ($attendanceType !== null && $existingEntry->attendence_type_id != $attendanceType) ||
                    $existingEntry->remark != $attendanceNote
                ) {

                    DB::table('student_attendences')
                        ->where('id', $existingEntry->id)
                        ->update([
                            'attendence_type_id' => $attendanceType, // Preserve existing if not provided
                            'remark' => $attendanceNote,
                            'updated_at' => now(),
                        ]);
                }
            } else {

                // If no entry exists, create a new one
                DB::table('student_attendences')->insert([
                    'student_session_id' => $data->id,
                    'date' => $date,
                    'attendence_type_id' => $attendanceType, // Can be null
                    'remark' => $attendanceNote,
                    'is_active' => 'no', // Assuming default value
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Attendance data processed successfully.',
        ], 200);
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


    public function getAttendance(Request $request)
    {
        // Validate the incoming request parameters
        $validated = $request->all();

        // Retrieve inputs from the validated request
        $year = $validated['year'];
        $month = $validated['month'];
        $student_id = $validated['student_id'];
        $session_id = $validated['session_id'];
        $student_session_id = StudentSession::where('student_id', $student_id)->where('session_id', $session_id)->first();
        if ($year && $month) {
            $attendance = StudentAttendences::with('attendanceType')
                ->where('student_session_id', $student_session_id->id)
                ->whereYear('date', $year) // Filter by year
                ->whereMonth('date', $month) // Filter by month
                ->get();
        } else {
            $attendance = StudentAttendences::with('attendanceType')
                ->where('student_session_id', $student_session_id->id)


                ->get();
        }


        return response()->json([
            'success' => true,
            'data' => $attendance,
        ], 200);
    }
}
