<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StudentListController extends Controller
{

    public function getStaffbyrole(Request $request)
    {
        // Role ID (use the provided role ID or default to 1)
        $role_id = $request->selectedRole;
        $leave_role_id = $request->selectedRoleLeave;

        $attendance = $request->attendance;
        $searchDate = $request->attendance_date;

        // Get pagination inputs, default to page 1 and 10 records per page if not provided
        $page = (int) $request->input('page');
        $perPage = (int) $request->input('perPage', 10);
        $keyword = $request->input('keyword');

        // Build the query
        $query = DB::table('staff');


        if ($attendance) {
            $query->select(
                'staff.*',
                'staff_designation.designation as designation',
                'staff_roles.role_id',
                'department.department_name as department',
                'roles.name as user_type',
                'staff_attendance.id as staff_attendance_id',
                'staff_attendance.date as attendance_date',

                'staff_attendance.staff_attendance_type_id as attendance_status',
                'staff_attendance.id as attendance_id',
                'staff_attendance.remark as attendance_note'
            );
        } else {
            $query->select(
                'staff.*',
                'staff_designation.designation as designation',
                'staff_roles.role_id',
                'department.department_name as department',
                'roles.name as user_type'
            );
        }

        $query->leftJoin('staff_designation', 'staff_designation.id', '=', 'staff.designation')
            ->leftJoin('department', 'department.id', '=', 'staff.department')
            ->leftJoin('staff_roles', 'staff_roles.staff_id', '=', 'staff.id')
            ->leftJoin('roles', 'staff_roles.role_id', '=', 'roles.id');
        if ($attendance) {
            $query->leftJoin('staff_attendance', function ($join) use ($searchDate) {
                $join->on('staff_attendance.staff_id', '=', 'staff.id')
                    ->where('staff_attendance.date', '=', $searchDate); // Filter by attendance date
            });
        }
        if ($role_id) {
            $query->where('staff_roles.role_id', $role_id);
        }

        if ($leave_role_id) {
            $query->where('staff_roles.role_id', $leave_role_id);
        }


        // Apply filtering based on keyword (searching in the 'firstname' field)
        if (!empty($keyword)) {
            $query->where('staff.name', 'like', '%' . $keyword . '%');
        }

        $query->where('staff.is_active', '1');

        // Apply pagination

        if ($leave_role_id) {

            $data = $query->get();
            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } else {
            $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            return response()->json([
                'success' => true,
                'data' => $paginatedData->items(), // Only return the current page data
                'current_page' => $paginatedData->currentPage(),
                'per_page' => $paginatedData->perPage(),
                'total' => $paginatedData->total(),
            ], 200);
        }

        // Return paginated data with total count and pagination details

    }
    public function searchdtByClassSection(Request $request)
    {
        // Extract request inputs with defaults
        $id = $request->input('id');
        $selectedSessionId = $request->input('selectedSessionId');
        $page = $request->input('page'); // Check if page is present (null if not provided)
        $perPage = (int) $request->input('perPage', 10); // Default to 10 records per page
        $selectedClass = $request->input('selectedClass');
        $selectedSection = $request->input('selectedSection');
        $keyword = $request->input('keyword');
        $bulkDelete = $request->input('bulkDelete', 0); // Default to 0 (no bulk delete)

        /* attendacne */
        $attendance = $request->attendance;
        $searchDate = $request->attendance_date;
        // Base query
        $query = Students::join('student_session', 'student_session.student_id', '=', 'students.id')
            ->join('classes', 'classes.id', '=', 'student_session.class_id')
            ->join('sections', 'sections.id', '=', 'student_session.section_id')
            ->leftJoin('categories', 'categories.id', '=', 'students.category_id');
        if ($attendance) {
            if ($searchDate) {
                $query->leftJoin('student_attendences', function ($join) use ($searchDate) {
                    $join->on('student_attendences.student_session_id', '=', 'student_session.id')
                        ->where('student_attendences.date', '=', $searchDate); // Filter by attendance date
                });
            } else {
                $query->leftJoin('student_attendences', 'student_attendences.student_session_id', '=', 'student_session.id');
            }
        }
        if ($attendance) {

            $query->select(
                'students.*',
                'student_session.class_id as class_id',
                'student_session.section_id as section_id',
                'classes.class as class_name',
                'sections.section as section_name',
                'categories.category as category_name',

                'student_session.id as student_session_id',
                'student_attendences.date as attendance_date',
                'student_attendences.biometric_attendence as student_biometric_attendence',

                'student_attendences.attendence_type_id as attendance_status',
                'student_attendences.id as attendance_id',
                'student_attendences.remark as attendance_note'
            );
            $query->where('students.is_active', 'yes');
        } else {
            $query->select(
                'students.*',
                'student_session.class_id as class_id',
                'student_session.section_id as section_id',
                'student_session.id as student_session_id',

                'classes.class as class_name',
                'sections.section as section_name',
                'categories.category as category_name'
            );
            /*   $query->where('students.is_active', 'yes'); */
        }



        // Bulk delete logic
        if ($bulkDelete == 1) {
            // Apply filters for class, section, and session
            if (!empty($selectedClass)) {
                $query->where('student_session.class_id', $selectedClass);
            }
            if (!empty($selectedSection)) {
                $query->where('student_session.section_id', $selectedSection);
            }
            if (!empty($selectedSessionId)) {
                $query->where('student_session.session_id', $selectedSessionId);
            }

            return response()->json([
                'success' => true,
                'data' => $query->get(),
            ], 200);
        }


        // Apply filters based on request parameters
        if (!empty($id)) {
            $query->where('students.id', $id);
            $student = $query->first(); // Fetch single record without pagination

            return response()->json([
                'success' => true,
                'data' => $student,
            ], 200);
        }

        if (!empty($selectedClass)) {
            $query->where('student_session.class_id', $selectedClass);
        }

        if (!empty($selectedSection)) {
            $query->where('student_session.section_id', $selectedSection);
        }

        if (!empty($selectedSessionId)) {
            $query->where('student_session.session_id', $selectedSessionId);
        }

        // Apply keyword search filter
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('students.firstname', 'like', '%' . $keyword . '%')
                    ->orWhereRaw('CONCAT(students.firstname, " ", students.lastname) LIKE ?', ['%' . $keyword . '%']);
            });
        }

        // Order by students ID
        $query->orderBy('students.id', 'desc');

        // Check if pagination is required
        if (is_null($page)) {
            // No pagination; return all data
            $data = $query->get();

            return response()->json([
                'success' => true,
                'data' => $data,
                'totalCount' => $data->count(),
            ], 200);
        }

        // Paginated response
        $perPage = max(1, min($perPage, 100)); // Ensure valid perPage value
        $paginatedData = $query->paginate($perPage, ['*'], 'page', (int) $page);

        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(),
            'totalCount' => $paginatedData->total(),
            'rowsPerPage' => $paginatedData->perPage(),
            'currentPage' => $paginatedData->currentPage(),
        ], 200);
    }


    public function studentBlukDelete(Request $request)
    {

        $studentIds =    $request->all();
        foreach ($studentIds as $studentId) {
            Students::where('id', $studentId)->delete();
        }

        return response()->json([
            'status' => 200
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
            ->where('students.is_active', 'no');

        // Apply filtering based on selectedClass
        if (!empty($selectedClass)) {
            $query->where('student_session.class_id', $selectedClass);
        }

        // Apply filtering based on selectedSection
        if (!empty($selectedSection)) {
            $query->where('student_session.section_id', $selectedSection);
        }

        if (!empty($keyword)) {
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('students.firstname', 'like', '%' . $keyword . '%')
                    ->orWhere('students.lastname', 'like', '%' . $keyword . '%')
                    ->orWhere(DB::raw("CONCAT(students.firstname, ' ', students.lastname)"), 'like', '%' . $keyword . '%');
            });
        }


        // Paginate the filtered students data
        $data = $query->orderBy('students.id', 'desc')->paginate($perPage, ['*'], 'page', $page);


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
