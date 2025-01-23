<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffAttendanceController extends Controller
{
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
        $query = StaffAttendance::select(
            'staff_attendance.*',
            'staff.name as staff_name',
            'staff.surname as staff_surname',
            'staff_attendance_type.type as staff_attendance_type'
        )
            ->leftJoin('staff', 'staff.id', '=', 'staff_attendance.staff_id')
            ->leftJoin('staff_attendance_type', 'staff_attendance_type.id', '=', 'staff_attendance.staff_attendance_type_id');





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
        $attendanceData = $request->input('attendance_data'); // Assuming JSON input in 'attendance_data'
        $date = $request->input('date');

        // Prepare data for bulk insert
        $formattedData = array_map(function ($data) use ($date) {
            return [
                'staff_id' => $data['id'],
                'date' => $date,
                'staff_attendance_type_id' => $data['attendance_type'],
                'remark' => $data['attendance_note'] ?? null, // Handle nullable field
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $attendanceData);

        // Insert into the database
        $inserted = DB::table('staff_attendance')->insert($formattedData);

        // Return response
        return response()->json([
            'success' => $inserted,
            'message' => $inserted ? 'Attendance data saved successfully.' : 'Failed to save attendance data.',
        ], $inserted ? 200 : 500);
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
