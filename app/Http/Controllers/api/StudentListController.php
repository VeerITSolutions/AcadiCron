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
        $id = $request->input('id');
        $selectedSessionId = $request->input('selectedSessionId');
        $page = (int) $request->input('page', 1); // Default to page 1 if not provided
        $perPage = (int) $request->input('perPage', 10); // Default to 10 records per page if not provided
        $selectedClass = $request->input('selectedClass');
        $selectedSection = $request->input('selectedSection');
        $keyword = $request->input('keyword');

        $bulkDelete = $request->input('bulkDelete');

        if ($bulkDelete == 1) {
            // Build the query
            $query = Students::join('student_session', 'student_session.student_id', '=', 'students.id')
                ->join('classes', 'classes.id', '=', 'student_session.class_id')
                ->join('sections', 'sections.id', '=', 'student_session.section_id')
                ->leftJoin('categories', 'categories.id', '=', 'students.category_id')
                ->select(
                    'students.*',
                    'student_session.class_id as class_id',
                    'student_session.section_id as section_id',
                    'classes.class as class_name',
                    'sections.section as section_name',
                    'categories.category as category_name'
                );

            // Apply filtering based on selectedClass
            if (!empty($selectedClass)) {
                $query->where('student_session.class_id', $selectedClass);
            }

            // Apply filtering based on selectedSection
            if (!empty($selectedSection)) {
                $query->where('student_session.section_id', $selectedSection);
            }

            // Execute the query
            $result = $query->get();

            // Return the result as JSON
            return response()->json([
                'success' => true,
                'data' => $result,
            ], 200);
        }

        // Ensure $perPage is a positive integer and set a maximum limit
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }

        // Build the query for students
        $query = Students::join('student_session', 'student_session.student_id', '=', 'students.id')
            ->join('classes', 'classes.id', '=', 'student_session.class_id')
            ->join('sections', 'sections.id', '=', 'student_session.section_id')
            ->leftjoin('categories', 'categories.id', '=', 'students.category_id')
            ->select(
                'students.*',
                'student_session.class_id as class_id',
                'student_session.section_id as section_id',
                'classes.class as class_name',
                'sections.section as section_name',
                'categories.category as category_name'
            );

        // Apply filtering based on student ID
        if (!empty($id)) {
            $query->where('students.id', $id);
            $student = $query->first(); // Fetch a single result without pagination

            return response()->json([
                'success' => true,
                'data' => $student,
            ], 200);
        }

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


        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('students.firstname', 'like', '%' . $keyword . '%')
                  ->orWhereRaw('CONCAT(students.firstname, " ", students.lastname) like ?', ['%' . $keyword . '%']);
            });
        }
        if (!empty($selectedSessionId)) {
            $query->where('student_session.session_id', $selectedSessionId);
        }


        // Paginate the filtered students data if id is not present
        $data = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->perPage(), // Number of rows per page
            'currentPage' => $data->currentPage(), // Current page
        ], 200);
    }




    public function getdisableStudent(Request $request)
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
        $query = DB::table('students')
        ->select(
            'classes.id',
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
            'students.father_name',
            'students.guardian_name',
            'students.guardian_relation',
            'students.guardian_phone',
            'students.guardian_address',
            'students.is_active',
            'students.created_at',
            'students.updated_at',
            'students.gender',
            'students.rte',
            'student_session.class_id as class_id',
            'student_session.session_id as session_id',
            'students.dis_reason',
            'students.dis_note'
        )
        ->join('student_session', 'student_session.student_id', '=', 'students.id')
        ->join('classes', 'student_session.class_id', '=', 'classes.id')
        ->join('sections', 'sections.id', '=', 'student_session.section_id')
        ->leftJoin('categories', 'students.category_id', '=', 'categories.id')
        /* ->where('student_session.session_id', $this->current_session) */
        ->where('students.is_active', 'no')
        ->orderBy('students.id');

        // Paginate the filtered students data
        $data = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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
