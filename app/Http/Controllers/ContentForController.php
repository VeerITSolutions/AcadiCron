<?php

namespace App\Http\Controllers;

use App\Models\ContentFor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentForController extends Controller
{
   /**
     * Display a listing of the resource.
     */

     public function index(Request $request, $id = null, $role = null)
{
    $page = (int) $request->input('page', 1); // Default to page 1 if not provided
    $perPage = (int) $request->input('perPage', 10); // Default to 10 records per page if not provided

    // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
    if ($perPage <= 0 || $perPage > 100) {
        $perPage = 10; // Default value if invalid
    }

    // Initialize the query
    $query = DB::table('content_for')
        ->join('contents', 'contents.id', '=', 'content_for.content_id')
        ->leftJoin('class_sections', 'class_sections.id', '=', 'contents.cls_sec_id')
        ->leftJoin('classes', 'classes.id', '=', 'class_sections.class_id')
        ->leftJoin('sections', 'sections.id', '=', 'class_sections.section_id')
        ->select([
            'contents.*',
            DB::raw("(SELECT GROUP_CONCAT(role) FROM content_for WHERE content_id = contents.id) as role"),
            'class_sections.id as class_section_id',
            'classes.class',
            'sections.section'
        ]);

    // Apply the role-based condition
    if ($role === "student") {
        $query->where(function($query) use ($id) {
            $query->where('content_for.role',
            'student')
                ->where(function ($query) use ($id) {
                    $query->where('content_for.created_by', $id)
                        ->orWhere('content_for.created_by', 0);
                });
        });
    } elseif ($role === "Teacher") {
        $query->where(function($query) use ($id) {
            $query->where('content_for.role', 'Teacher')
                ->where(function ($query) use ($id) {
                    $query->where('content_for.created_by', $id)
                        ->orWhere('content_for.created_by', 0);
                });
        });
    }

    // Group by content ID
    $query->groupBy('contents.id');

    // Count the total number of records before applying pagination
    $total = $query->count();

    // Apply pagination
    $paginatedQuery = $query->forPage($page, $perPage)->get();

        // Return paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $paginatedQuery, // Only return the current page data
            'totalCount' => $total,    // Total number of records
            'rowsPerPage' => $perPage, // Number of rows per page
            'currentPage' => $page,    // Current page
            'lastPage' => ceil($total / $perPage), // Total number of pages
        ], 200);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = ContentFor::where('type', $validatedData['type'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'type already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new ContentFor();
        $category->type = $validatedData['type'];
        $category->is_active = 1;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Leave Type saved successfully',
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
        $category = ContentFor::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required',

        ]);

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
            $category = ContentFor::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Leave type deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
