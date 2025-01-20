<?php

namespace App\Http\Controllers;

use App\Models\StaffLeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class StaffLeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null)
{
    $page = $request->input('page', 1); // Default to page 1 if not provided
    $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided
    $id = $request->input('id');
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
    if ($id) {
        $query->where('staff_leave_request.id', $id);


        $data = $query->get();
    // Return the paginated data as a response
    return response()->json([
        'status' => 200,
        'data' => $data,
    ], 200);
    }else{
          // Paginate the results
    $data = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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


}


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();

        // Create a new leaverequest
        $leaverequest = new StaffLeaveRequest();

        $leaveFrom = Carbon::parse($validatedData['leave_from']);
        $leaveTo = Carbon::parse($validatedData['leave_to']);

        // Calculate the difference
        $dateDifference = $leaveFrom->diffInDays($leaveTo);


        $leaverequest->leave_from  = $validatedData['leave_from'];
        $leaverequest->leave_to  = $validatedData['leave_to'];
        $leaverequest->leave_type_id   = $validatedData['selectedLeaveType'];
        $leaverequest->date  = $validatedData['date'];
        $leaverequest->leave_days  = $dateDifference;
        $leaverequest->employee_remark  = $validatedData['employee_remark'];
        $leaverequest->admin_remark  = $validatedData['admin_remark'] ?? 0;
        $leaverequest->status  = $validatedData['status'];
        $leaverequest->staff_id  = $validatedData['selectedStaff'];
       $leaverequest->applied_by = $validatedData['selectedRoleLeave'];
       


        /* imag update */
        /*  $leaverequest->document_file  = 1; */

        $file = $request->file('document_file');
        if($file)
        {
           $imageName = $leaverequest->staff_id .'_document_file_'. time(); // Example name
           $imageSubfolder = "/staff_documents/".$leaverequest->staff_id;   // Example subfolder
           $full_path = 0;
           $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
           $leaverequest->document_file  =  $validatedData['document_file'] = $imagePath;
        }



        $leaverequest->save();


        return response()->json([
            'status' => 200,
            'message' => 'Staff Leave saved successfully',
            'leaverequest' => $leaverequest,
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

         // Find the leaverequest by id
         $leaverequest = StaffLeaveRequest::findOrFail($validatedData['currentLeaveId']);

         // Parse dates
         $leaveFrom = Carbon::parse($validatedData['leave_from']);
         $leaveTo = Carbon::parse($validatedData['leave_to']);

         // Calculate the difference in days (inclusive)
         $dateDifference = $leaveFrom->diffInDays($leaveTo) + 1;

         // Update fields
         $leaverequest->leave_days = $dateDifference;
         $leaverequest->applied_by = $validatedData['selectedRoleLeave'];
         $leaverequest->leave_from = $validatedData['leave_from'];
         $leaverequest->leave_to = $validatedData['leave_to'];
         $leaverequest->leave_type_id   = $validatedData['selectedLeaveType'];
         $leaverequest->date  = $validatedData['date'];
         $leaverequest->employee_remark = $validatedData['employee_remark'];
         $leaverequest->admin_remark = $validatedData['admin_remark'];
         $leaverequest->status = $validatedData['status'];
         $leaverequest->staff_id  = $validatedData['selectedStaff'];


         // Handle file upload if present
         if ($request->hasFile('document_file')) {
             $file = $request->file('document_file');
             $imageName = $leaverequest->id . '_document_file_' . time();
             $imageSubfolder = "/staff_documents/" . $leaverequest->id;
             $full_path = false; // Adjust based on your uploadImage logic
             $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
             $leaverequest->document_file = $imagePath;
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
            // Find the leaverequest by ID
            $leaverequest = StaffLeaveRequest::findOrFail($id);

            // Delete the leaverequest
            $leaverequest->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Staff Leave deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the leaverequest was not found)
            return response()->json(['success' => false, 'message' => 'Staff Leave  deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
