<?php

namespace App\Http\Controllers;

use App\Helpers\EncLib;
use App\Libraries\CustomLib;
use App\Models\Staff;
use App\Models\SubjectTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $id = null, $role = null)
    {
        // Get pagination inputs, default to page 1 and 10 records per page if not provided
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);

        // Role ID (replace or customize as per your logic)
        $role_id = 1;

        // Build the query


        $query = DB::table('class_teacher')
            ->join('classes', 'classes.id', '=', 'class_teacher.class_id')
            ->join('sections', 'sections.id', '=', 'class_teacher.section_id')
            ->groupBy('class_teacher.class_id', 'class_teacher.section_id')
            ->orderByRaw('LENGTH(classes.class), classes.class')
            ->select(
                DB::raw('MAX(class_teacher.id) as id'),
                'classes.class',
                'sections.section'
            );




        // Apply pagination
        $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Return paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(), // Only return the current page data
            'current_page' => $paginatedData->currentPage(),
            'per_page' => $paginatedData->perPage(),
            'total' => $paginatedData->total(),
        ], 200);
    }

    public function getInventoryStaff()
    {
        $data = DB::table('staff')
            ->selectRaw("CONCAT_WS(' ', staff.name, staff.surname) as name, staff.employee_id")
            ->where('staff.is_active', 1)
            ->get()
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $data

        ], 200);
    }


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


    public function getSingleData(Request $request)
    {
        // Role ID (use the provided role ID or default to 1)
        $id = $request->id;

        // Get pagination inputs, default to page 1 and 10 records per page if not provided
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
        $keyword = $request->input('keyword');


        // Build the query
        $query = Staff::select(
            'staff.*',
            'staff_designation.designation as designation_name',
            'staff_roles.role_id',
            'department.department_name as department_name',
            'roles.name as user_type'
        )

            ->with(['staffLeaveDetails' => function ($query) use ($keyword) {

                $query->with('leaveType');
            }])
            ->leftJoin('staff_designation', 'staff_designation.id', '=', 'staff.designation')
            ->leftJoin('department', 'department.id', '=', 'staff.department')
            ->leftJoin('staff_roles', 'staff_roles.staff_id', '=', 'staff.id')
            ->leftJoin('roles', 'staff_roles.role_id', '=', 'roles.id');

        if ($id) {
            $query->where('staff.id', $id);
        }

        // Apply filtering based on keyword (searching in the 'firstname' field)
        if (!empty($keyword)) {
            $query->where('staff.name', 'like', '%' . $keyword . '%');
        }

        // $query->where('staff.is_active', '1');

        // Apply pagination
        $data = $query->first();

        // Return paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }







    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get all request data
        $validatedData = $request->all();

        // Generate and encrypt password
        $encLib = new EncLib();
        
        

        // Create a new staff instance
        $staff = new Staff();
        $staff->fill($validatedData); // Fill all properties at once
        $staff->password = Hash::make($getpassword = $encLib->encrypt());
        
        $staff->date_of_joining = $validatedData['date_of_joining'] ?? now();
        $staff->lang_id = 0;

        // Save the staff record
        $staff->save();

        // Handle file uploads
        $staff->image = $this->handleFileUpload($request, 'image', $staff->id);
        $staff->resume = $this->handleFileUpload($request, 'resume', $staff->id);
        $staff->joining_letter = $this->handleFileUpload($request, 'joining_letter', $staff->id);
        $staff->other_document_file = $this->handleFileUpload($request, 'other_document_file', $staff->id);

        // Save updated file paths
        $staff->save();

        return response()->json([
            'status' => 200,
            'message' => 'Created successfully',
            'staff' => $staff,
        ], 201);
    }

    /**
     * Handle file upload and return the file path.
     */
    private function handleFileUpload(Request $request, $fileKey, $staffId)
    {
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $imageName = "{$staffId}_{$fileKey}_" . time();
            $imageSubfolder = "/staff_documents/{$staffId}";
            $full_path = 0;

            return uploadImage($file, $imageName, $imageSubfolder, $full_path);
        }
        return null;
    }

    public function getStaffSyllabusHTML(Request $request)
    {
        $notificationModel = new \App\Models\NotificationSetting();
        $settingModel = new \App\Models\SchSettings();
        $NotificationSetting = new \App\Models\NotificationSetting();
        $customLib = new CustomLib($notificationModel, $settingModel, $NotificationSetting); // Assuming you have a similar custom library
        $startWeekday = 'Monday'; // Replace with your logic to get the start weekday

        $thisWeekStart = $customLib->dateFormatToYYYYMMDD($request->input('date'));

        $prevWeekStart = date("Y-m-d", strtotime('last ' . $startWeekday, strtotime($thisWeekStart)));
        $nextWeekStart = date("Y-m-d", strtotime('next ' . $startWeekday, strtotime($thisWeekStart)));
        $thisWeekEnd = date("Y-m-d", strtotime($thisWeekStart . " +6 day"));

        $data = [
            'this_week_start' => $customLib->dateformat($thisWeekStart),
            'this_week_end' => $customLib->dateformat($thisWeekEnd),
            'prev_week_start' => $customLib->dateformat($prevWeekStart),
            'next_week_start' => $customLib->dateformat($nextWeekStart),
        ];

        Session::put('top_menu', 'Time_table');

        $staffId = $request->input('staff_id');
        $data['timetable'] = [];
        $days = $customLib->getDaysname();
        $userData = $customLib->getUserData();
        $roleId =   2; //$userData['role_id'];
        $condition = '';

        foreach ($days as $dayKey => $dayValue) {
            $timetableId = '';
            $concate = 'no';

            if (isset($roleId) && $roleId == 2 /* && $userData['class_teacher'] == 'yes' */) {
                $subjectTimetable = new SubjectTimetable();
                $myClassSubjects = $subjectTimetable->getByStaffClassTeacherAndDay($staffId, $dayKey);

                if (!empty($myClassSubjects[0]->timetable_id)) {
                    $timetableId = $myClassSubjects[0]->timetable_id;
                    $concate = 'yes';
                }
            }
            $subjectTimetable = new SubjectTimetable();
            $mySubjects = $subjectTimetable->getByTeacherSubjectandDay($staffId, $dayKey);

            if (!empty($mySubjects[0]->timetable_id)) {
                $timetableId = $concate == 'yes' ? $timetableId . ',' . $mySubjects[0]->timetable_id : $mySubjects[0]->timetable_id;
            }

            $condition = empty($timetableId) ? " and subject_timetable.id in(0) " : " and subject_timetable.id in(" . $timetableId . ") ";

            $subjectTimetable = new SubjectTimetable();

            $data['timetable'][$dayKey] = $subjectTimetable->getSyllabusSubject($staffId, $dayKey, $condition);
        }

        $data['staff_id'] = $staffId;
        return response()->json([
            'success' => true,
            'data' => $data,
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

        // Find the category by id
        $staff = Staff::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();


        $file = $request->file('image');
        if ($file) {
            $imageName = $staff->id . '_image_' . time(); // Example name
            $imageSubfolder = "/staff_documents/" . $staff->id;      // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['image'] = $imagePath;
        }

        $file = $request->file('resume');
        if ($file) {
            $imageName = $staff->id . '_resume_' . time(); // Example name
            $imageSubfolder = "/staff_documents/" . $staff->id;      // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['resume'] = $imagePath;
        }

        $file = $request->file('joining_letter');
        if ($file) {
            $imageName = $staff->id . '_joining_letter_' . time(); // Example name
            $imageSubfolder = "/staff_documents/" . $staff->id;      // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['joining_letter'] = $imagePath;
        }

        $file = $request->file('other_document_file');
        if ($file) {
            $imageName = $staff->id . '_other_document_file_' . time(); // Example name
            $imageSubfolder = "/staff_documents/" . $staff->id;   // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['other_document_file'] = $imagePath;
        }

        // Update the category
        $staff->update($validatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'data' => $staff,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $staff = Staff::findOrFail($id);

            // Delete the category
            $staff->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Staff  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Staff  deletion failed: ' . $e->getMessage()], 500);
        }
    }

    public function StaffDisabled(Request $request)
    {
        $staff_id = $request->input('id');
        $date = $request->input('date');
    
        $staff = Staff::find($staff_id);
    
        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Staff not found.',
            ], 404);
        }
    
        $staff->update([
            'is_active' => $staff->is_active == '0' ? '1' : '0',
            'disable_at' => $date,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => $staff->is_active == '1' ? 'Staff enabled successfully.' : 'Staff disabled successfully.',
        ], 200);
    }
    



    public function StaffLoginDetails(Request $request)
    {
        // Fetching only users with the 'staff' role
        $staffUsers = DB::table('users')
            ->select('users.*')
            ->where('users.role', 'staff'); // Only 'staff' role

        $result = $staffUsers->get(); // Get the result

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'Staff data fetched successfully.',
        ], 201);
    }


    public function ChangePassword(Request $request)
    {
           $validatedData = $request->all();

           $encLib = new EncLib();
           $getpassword = $encLib->encrypt($validatedData['password']);
   
    
           $hashedPassword = Hash::make($validatedData['password']);

           $staff = Staff::find($validatedData['id']);
           $staff->password = $hashedPassword;
           $staff->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Password updated successfully',
            'staff' => $staff,
        ], 200); // 200 OK status code
    }
    
}
