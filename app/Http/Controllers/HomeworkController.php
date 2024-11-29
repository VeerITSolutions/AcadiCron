<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeworkController extends Controller
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
    $query = DB::table('homework')
        ->select(
           'classes.class as class_name', 'sections.section as section_name',
            'homework.*',
            'subject_group_subjects.subject_id',
            'subject_group_subjects.id as subject_group_subject_id',
            'subjects.name as subject_name',
            'subject_groups.id as subject_groups_id',
            'subject_groups.name',
            DB::raw('(select count(*) from submit_assignment where submit_assignment.homework_id = homework.id) as assignments')
        )
        ->join('classes', 'classes.id', '=', 'homework.class_id')
        ->join('sections', 'sections.id', '=', 'homework.section_id')
        ->join('subject_group_subjects', 'subject_group_subjects.id', '=', 'homework.subject_group_subject_id')
        ->join('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
        ->join('subject_groups', 'subject_group_subjects.subject_group_id', '=', 'subject_groups.id');
        //->where('homework.session_id', $this->current_session); // Replace with your session logic

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


        // Create a new category
        $category = new Homework();
        $category->class_id = $validatedData['class_id'];
        $category->section_id = $validatedData['section_id'];
        $category->session_id = $validatedData['session_id'];
        $category->homework_date = $validatedData['homework_date'];
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
            'message' => 'Home Workd  saved successfully',
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
        $category = Homework::findOrFail($id);

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
            $category = Homework::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Homework  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }

}
