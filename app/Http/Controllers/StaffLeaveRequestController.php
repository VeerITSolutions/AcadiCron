<?php

namespace App\Http\Controllers;

use App\Models\StaffLeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffLeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null)
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

    // Build the query
    $query = DB::table('staff_leave_request')
        ->join('staff', 'staff.id', '=', 'staff_leave_request.staff_id')
        ->join('leave_types', 'leave_types.id', '=', 'staff_leave_request.leave_type_id')
        ->select([
            'staff.name',
            'staff.surname',
            'staff.employee_id',
            'staff_leave_request.*',
            'leave_types.type'
        ])
        ->where('staff.is_active', 1)
        ->orderBy('staff_leave_request.id', 'desc');

    // Apply the conditional staff_id filter if $id is provided
    if ($id != null) {
        $query->where('staff_leave_request.staff_id', $id);
    }

    // Paginate the results
    $data = $query->paginate($perPage, ['*'], 'page', $page);

    // Return the paginated data as a response
    return response()->json([
        'success' => true,
        'data' => $data->items(), // Only return the current page data
        'totalCount' => $data->total(), // Total number of records
        'rowsPerPage' => $data->perPage(), // Number of rows per page
        'currentPage' => $data->currentPage(), // Current page
        'lastPage' => $data->lastPage(), // Total number of pages
    ], 200);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();



        // Create a new category
        $category = new StaffLeaveRequest();
        $category->staff_id  = $validatedData['staff_id '];
        $category->leave_type_id   = $validatedData['leave_type_id  '];
        $category->leave_from  = $validatedData['leave_from '];
        $category->leave_to  = $validatedData['leave_to'];
        $category->leave_days  = $validatedData['leave_days'];
        $category->employee_remark  = $validatedData['employee_remark'];
        $category->admin_remark  = $validatedData['admin_remark'];
        $category->status  = $validatedData['status'];
        $category->applied_by  = $validatedData['applied_by'];
        $category->document_file  = $validatedData['document_file'];
        $category->date  = $validatedData['date'];
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Staff Leave saved successfully',
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
        $category = StaffLeaveRequest::findOrFail($id);

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
            $category = StaffLeaveRequest::findOrFail($id);

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
