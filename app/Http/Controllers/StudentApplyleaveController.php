<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Classes;
use App\Models\SchSettings;
use App\Models\StudentApplyleave;

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

    // Validate form input
    $validator = Validator::make($request->all(), [
        'selectedClass' => 'nullable|integer',
        'selectedSection' => 'nullable|integer',
        'student' => 'nullable|integer|exists:students,id',  // Validate if student exists in the 'students' table
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // Build the query
    $query = DB::table('student_applyleave')
        ->leftJoin('student_session', 'student_applyleave.student_session_id', '=', 'student_session.id')
        ->leftJoin('students', 'students.id', '=', 'student_session.student_id') // Join with the students table
        ->leftJoin('classes', 'classes.id', '=', 'student_session.class_id')
        ->leftJoin('sections', 'sections.id', '=', 'student_session.section_id')
        ->leftJoin('staff', 'staff.id', '=', 'student_applyleave.approve_by')

        ->select(
            'student_applyleave.*',
            'students.firstname',
            'students.lastname',
            'students.id as student_id',  // Include student_id for reference
            'classes.class as class_name',
            'sections.section as section_name',
            'staff.name as staff_name',
            'staff.surname as staff_surname'


        )
        ->orderBy('student_applyleave.created_at', 'desc');

    // Apply filtering based on selectedClass
    if (!empty($selectedClass)) {
        $query->where('student_session.class_id', $selectedClass);
    }

    // Apply filtering based on selectedSection
    if (!empty($selectedSection)) {
        $query->where('student_session.section_id', $selectedSection);
    }

    // Apply filtering based on student
    if (!empty($student)) {
        $query->where('students.id', $student);  // Filter by student ID if provided
    }

    // Apply pagination
    $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with pagination details and full name concatenated
    $data = $paginatedData->items();
    foreach ($data as $key => $value) {
        // Concatenate the full name directly using object notation
        $fullName = $value->firstname;


        if (!empty($value->lastname)) {
            $fullName .= ' ' . $value->lastname;
        }

        // Add the full name to the result as 'student_name'
        $data[$key]->student_name = $fullName; // Use object notation to set the value
    }

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

    public function create(Request $request){

        // Validate the incoming request
        $validatedData = $request->all();

        // Create a new category
        $category = new StudentApplyleave();

        $category->student_session_id = $validatedData['student_session_id'] ?? null;
        $category->from_date = $validatedData['from_date'] ?? null;
        $category->to_date = $validatedData['to_date'] ?? null;
        $category->apply_date = $validatedData['apply_date'] ?? null;
        $category->created_at = $validatedData['created_at'] ?? null;
        $category->reason = $validatedData['reason'] ?? null;
        $category->approve_by = $validatedData['approve_by'] ?? null;
        $category->request_type = $validatedData['request_type'] ?? null;
        $category->status = $validatedData['status'] ?? null;
        $category->docs = $validatedData['docs'] ?? null;


        /* imag update */
        /*  $category->document_file  = 1; */

        $file = $request->file('docs');
        if($file)
        {
           $imageName = $category->staff_id .'_docs_'. time(); // Example name
           $imageSubfolder = "/student_leavedocuments/".$category->staff_id;   // Example subfolder
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

         $category->student_session_id  = $validatedData['student_session_id'];
         $category->from_date  = $validatedData['from_date'];
         $category->to_date  = $validatedData['to_date'];
         $category->apply_date  = $validatedData['apply_date'];
         $category->created_at  = $validatedData['created_at'];
         $category->reason  = $validatedData['reason'];
         $category->approve_by  = $validatedData['approve_by'];
         $category->request_type  = $validatedData['request_type'];
         $category->status  = $validatedData['status'];


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
