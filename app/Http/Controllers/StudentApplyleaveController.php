<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Classes;
use App\Models\SchSettings;
use App\Models\StudentApplyleave;
use App\Models\StudentSession;

class StudentApplyleaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize pagination variables
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
        $selectedClass = $request->input('selectedClass');
        $selectedSection = $request->input('selectedSection');
        $student = $request->input('student');  // Get student input from the request
        $keyword = $request->input('keyword');


        $query = DB::table('student_applyleave')
            ->leftJoin('student_session', 'student_applyleave.student_session_id', '=', 'student_session.id')
            ->leftJoin('students', 'students.id', '=', 'student_session.student_id') // Join with the students table
            ->leftJoin('classes', 'classes.id', '=', 'student_session.class_id')
            ->leftJoin('sections', 'sections.id', '=', 'student_session.section_id')
            ->leftJoin('staff', 'staff.id', '=', 'student_applyleave.approve_by')

            ->select(
                'student_applyleave.*',
                'students.firstname as student_firstname',
                'students.lastname as student_lastname',
                'students.id as student_id',  // Include student_id for reference
                'classes.class as class_name',
                'sections.section as section_name',
                'staff.name as staff_name',
                'staff.surname as staff_surname'

            )
            ->orderBy('student_applyleave.id');

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
            $query->where(function ($q) use ($keyword) {
                $q->where('students.firstname', 'like', '%' . $keyword . '%')
                    ->orWhereRaw('CONCAT(students.firstname, " ", students.lastname) like ?', ['%' . $keyword . '%']);
            });
        }
        // Apply filtering based on student
        if (!empty($student)) {
            $query->where('students.id', $student);  // Filter by student ID if provided
        }


        // Apply pagination
        $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);

        // Return paginated data with pagination details and full name concatenated
        $data = $paginatedData->items();


        // Return paginated data with pagination details
        return response()->json([
            'success' => true,
            'data' => $data, // Current page data with student names
            'current_page' => $paginatedData->currentPage(),
            'per_page' => $paginatedData->perPage(),
            'total' => $paginatedData->total(),
        ], 200);
    }



    /**
     * Show the form for creating a new resource.
     */

    public function changeStatus(Request $request)
    {

        $id = $request->id;
        $role_id = $request->role_id;



        // Find the category by id
        $leaverequest = StudentApplyleave::where('id', $id)->first();

        if ($leaverequest->status == '1') {
            $leaverequest->status  = 0;
            $leaverequest->approve_by  =  $role_id;
        } else {

            $leaverequest->status  = 1;
            $leaverequest->approve_by  = $role_id;
        }

        $leaverequest->update();
        return response()->json([
            'status' => 200,
            'message' => 'successfully',
            'category' => $leaverequest,
        ], 201); // 201 Created status code


    }

    public function create(Request $request)
    {



        // Validate the incoming request
        $validatedData = $request->all();

        $get_student_session_id =    StudentSession::where('student_id', $validatedData['selectedStudent'])->where('session_id', $validatedData['getselectedSessionId'])->first();

        // Create a new category
        $category = new StudentApplyleave();

        $category->student_session_id = $get_student_session_id->id ?? 0;
        $category->from_date = $validatedData['from_date'] ?? null;
        $category->to_date = $validatedData['to_date'] ?? null;
        $category->apply_date = $validatedData['apply_date'] ?? null;
        $category->created_at = $validatedData['created_at'] ?? now();
        $category->reason = $validatedData['reason'] ?? null;
        $category->approve_by = $validatedData['approve_by'] ?? 0;
        $category->request_type = $validatedData['request_type'] ?? 0;
        $category->status = $validatedData['status'] ?? 0;
        $category->docs = $validatedData['docs'] ?? null;


        /* imag update */
        /*  $category->document_file  = 1; */

        $file = $request->file('docs');
        if ($file) {
            $imageName = $category->staff_id . '_docs_' . time(); // Example name
            $imageSubfolder = "/student_leavedocuments/" . $category->staff_id;   // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $category->docs  =  $validatedData['docs'] = $imagePath;
        }

        $category->save();
        return response()->json([
            'status' => 200,
            'message' => 'Applay Leave saved successfully',
            'category' => $category,
        ], 201); // 201 Created status code
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
    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->all();

        // Find the category by id
        $leaverequest = StudentApplyleave::findOrFail($validatedData['currentLeaveId']);

        $leaverequest->student_session_id  = $validatedData['student_session_id'];
        $leaverequest->from_date  = $validatedData['from_date'];
        $leaverequest->to_date  = $validatedData['to_date'];
        $leaverequest->apply_date  = $validatedData['apply_date'];
        $leaverequest->created_at  = $validatedData['created_at'];
        $leaverequest->reason  = $validatedData['reason'];
        $leaverequest->approve_by  = $validatedData['approve_by'];
        $leaverequest->request_type  = $validatedData['request_type'];
        $leaverequest->status  = $validatedData['status'];


        // Handle file upload if present
        if ($request->hasFile('docs')) {
            $file = $request->file('docs');
            $imageName = $leaverequest->id . '_docs_' . time();
            $imageSubfolder = "/student_leavedocuments/" . $leaverequest->id;
            $full_path = false; // Adjust based on your uploadImage logic
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $leaverequest->docs = $imagePath;
        }

        // Save the updated model
        $leaverequest->save();

        return response()->json([
            'status' => 200,
            'message' => 'Edit successful',
            'leaverequest' => $leaverequest,
        ], 200); // 200 OK status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = StudentApplyleave::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Staff Leave deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Staff Leave  deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
