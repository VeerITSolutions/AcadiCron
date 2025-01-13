<?php

namespace App\Http\Controllers;

use App\Models\LeaveTypes;
use Illuminate\Http\Request;
use DB;

class LeaveTypesController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Paginate the students data
        $data = LeaveTypes::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->lastPage(), // Total number of pages
            'currentPage' => $data->currentPage(), // Current page
            'message' => $message,
        ], 200);
    }

    public function allotedLeaveType($id) {
        $data = DB::table('staff_leave_details')
            ->join('leave_types', 'staff_leave_details.leave_type_id', '=', 'leave_types.id')
            ->where('staff_id', $id)
            ->select('staff_leave_details.*', 'leave_types.type', 'leave_types.id as typeid')
            ->get();


            return response()->json([
                'success' => true,
                'data' => $data
             
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
        $existingCategory = LeaveTypes::where('type', $validatedData['type'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'type already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new LeaveTypes();
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
        $category = LeaveTypes::findOrFail($id);

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
            $category = LeaveTypes::findOrFail($id);

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
