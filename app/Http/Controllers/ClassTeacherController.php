<?php

namespace App\Http\Controllers;

use App\Models\ClassTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassTeacherController extends Controller
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
    ->join('staff', 'staff.id', '=', 'class_teacher.staff_id')
    ->groupBy('class_teacher.class_id', 'class_teacher.section_id')
    ->orderByRaw('LENGTH(classes.class), classes.class')
    ->select(
        DB::raw('MAX(class_teacher.id) as id'),
        'classes.class',
        'sections.section',
        DB::raw('MAX(staff.name) as name'),  // Apply aggregate function
        DB::raw('MAX(staff.surname) as surname')  // Apply aggregate function
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



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new classteacher
       
       
       foreach($validatedData['staff_id'] as $value){

        $classteacher = new ClassTeacher();
        $classteacher->class_id = $validatedData['class_id'];
        $classteacher->staff_id = $value;
        $classteacher->section_id = $validatedData['section_id'];
        $classteacher->session_id = $validatedData['session_id'];

        $classteacher->save();
       }
       

       

        return response()->json([
            'success' => true,
            'message' => 'Class Teacher saved successfully',
            'classteacher' => $classteacher,
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

        // Find the classteacher by id
        $classteacher = ClassTeacher::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

        // Update the classteacher
        $classteacher->update($validatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'classteacher' => $classteacher,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the classteacher by ID
            $classteacher = ClassTeacher::findOrFail($id);

            // Delete the classteacher
            $classteacher->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'class teacher  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the classteacher was not found)
            return response()->json(['success' => false, 'message' => 'class teacher deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
