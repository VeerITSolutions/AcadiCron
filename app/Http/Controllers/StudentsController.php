<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
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
    $query = DB::table('students')
    ->select('students.*');


// Apply pagination
$paginatedData = $query->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'total' => $paginatedData->total(),
    ], 200);
     }


     public function searchNonPromotedStudents(Request $request,$promoted_session_id , $promoted_class_id, $promoted_section_id, $class_id, $section_id, $current_session)
     {
          // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Role ID (replace or customize as per your logic)
    $role_id = 1;

    // Build the query


    $query = DB::table('students')
    ->join('student_session', 'student_session.student_id', '=', 'students.id')
    ->join('classes', 'student_session.class_id', '=', 'classes.id')
    ->join('sections', 'student_session.section_id', '=', 'sections.id')
    ->leftJoin('categories', 'students.category_id', '=', 'categories.id')
    ->leftJoin(DB::raw("(SELECT * FROM student_session WHERE session_id = {$promoted_session_id} AND class_id = {$promoted_class_id} AND section_id = {$promoted_section_id}) AS promoted_students"), 'promoted_students.student_id', '=', 'students.id')
    ->where('student_session.session_id', '=', $current_session)
    ->where('students.is_active', '=', 'yes')
    ->where('student_session.class_id', '=', $class_id)
    ->where('student_session.section_id', '=', $section_id)
    ->whereNull('promoted_students.id')
    ->orderBy('students.id')
    ->select(
        'promoted_students.id as promoted_student_id',
        'classes.id as class_id',
        'student_session.id as student_session_id',
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
        DB::raw("IFNULL(students.category_id, 0) as category_id"),
        DB::raw("IFNULL(categories.category, '') as category"),
        'students.adhar_no',
        'students.samagra_id',
        'students.bank_account_no',
        'students.bank_name',
        'students.ifsc_code',
        'students.guardian_name',
        'students.guardian_relation',
        'students.guardian_phone',
        'students.guardian_address',
        'students.is_active',
        'students.created_at',
        'students.updated_at',
        'students.father_name',
        'students.rte',
        'students.gender'
    );


// Apply pagination
$paginatedData = $query->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
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
        $category = new Students();
        $category->class_id = $validatedData['class_id'];
        $category->section_id = $validatedData['section_id'];
        $category->session_id = $validatedData['session_id'];
        $category->Students_date = $validatedData['Students_date'];
        $category->submit_date = $validatedData['submit_date'];
        $category->staff_id = $validatedData['staff_id'];
        $category->subject_group_subject_id = $validatedData['subject_group_subject_id'];
        $category->subject_id = $validatedData['subject_id'];
        $category->description = $validatedData['description'];
        $category->create_date = $validatedData['create_date'];
        $category->evaluation_date = $validatedData['evaluation_date'];
        $category->document = $validatedData['document'];
        $category->created_by = $validatedData['created_by'];
        $category->evaluated_by = $validatedData['evaluated_by'];
        $category->subject_name = $validatedData['subject_name'];
        $category->subject_groups_id = $validatedData['subject_groups_id'];
        $category->name = $validatedData['name'];
        $category->assignments = $validatedData['assignments'];

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Certificate saved successfully',
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


    public function update(Request $request,string $id)
    {

        // Find the category by id
        $category = Students::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

        // Update the category
        $category->update($validatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $category,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = Students::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Students  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
