<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StudentListController extends Controller
{
    public function searchdtByClassSection(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided
        $selectedClass = $request->input('selectedClass');
        $selectedSection = $request->input('selectedSection');
        $keyword = $request->input('keyword');

        // Validate inputs
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Build the query for students
        $query = Students::join('student_session', 'student_session.student_id', '=', 'students.id')


            ->join('classes', 'classes.id', '=', 'student_session.class_id')
        ->join('sections', 'sections.id', '=', 'student_session.section_id')


        ->select('students.*', 'student_session.class_id as class_id', 'student_session.section_id as section_id','classes.class as class_name', 'sections.section as section_name');

        // Apply filtering based on selectedClass
        if (!empty($selectedClass)) {
            $query->where('student_session.class_id', $selectedClass);
        }

        // Apply filtering based on selectedSection
        if (!empty($selectedSection)) {
            $query->where('student_session.section_id', $selectedSection);
        }

        // Apply filtering based on keyword (searching in the 'firstname' field)
        if (!empty($keyword)) {
            $query->where('students.firstname', 'like', '%' . $keyword . '%');
        }

        // Paginate the filtered students data
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->perPage(), // Number of rows per page
            'currentPage' => $data->currentPage(), // Current page
        ], 200);
    }



}
