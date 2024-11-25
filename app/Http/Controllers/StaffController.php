<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


     public function getStaffbyrole(Request $request, $id = null, $role = null)
     {
         // Role ID (use the provided role ID or default to 1)
         $role_id = $id ?: $role ?: 2;
     
         // Get pagination inputs, default to page 1 and 10 records per page if not provided
         $page = (int) $request->input('page', 1);
         $perPage = (int) $request->input('perPage', 10);
     
         // Build the query
         $query = DB::table('staff')
             ->select('staff.*',
                      'staff_designation.designation as designation',
                      'staff_roles.role_id',
                      'department.department_name as department',
                      'roles.name as user_type')
             ->leftJoin('staff_designation', 'staff_designation.id', '=', 'staff.designation')
             ->leftJoin('department', 'department.id', '=', 'staff.department')
             ->leftJoin('staff_roles', 'staff_roles.staff_id', '=', 'staff.id')
             ->leftJoin('roles', 'staff_roles.role_id', '=', 'roles.id')
             ->where('staff_roles.role_id', $role_id)
             ->where('staff.is_active', '1');
     
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
        $staff = new Staff();
        
        $staff->employee_id = $validatedData['employee_id'];
        $staff->lang_id = $validatedData['lang_id'];
        $staff->department = $validatedData['department'];
        $staff->designation = $validatedData['designation'];
        $staff->qualification = $validatedData['qualification'];
        $staff->work_exp = $validatedData['work_exp'];
        $staff->name = $validatedData['name'];
        $staff->surname = $validatedData['surname'];
        $staff->father_name = $validatedData['father_name'];
        $staff->mother_name = $validatedData['mother_name'];
        $staff->contact_no = $validatedData['contact_no'];
        $staff->emergency_contact_no = $validatedData['emergency_contact_no'];
        $staff->email = $validatedData['email'];
        $staff->dob = $validatedData['dob'];
        $staff->marital_status = $validatedData['marital_status'];
        $staff->date_of_joining = $validatedData['date_of_joining'];
        $staff->date_of_leaving = $validatedData['date_of_leaving'];
        $staff->local_address = $validatedData['local_address'];
        $staff->permanent_address = $validatedData['permanent_address'];
        $staff->note = $validatedData['note'];
        $staff->image = $validatedData['image'];
        $staff->password = $validatedData['password'];
        $staff->gender = $validatedData['gender'];
        $staff->account_title = $validatedData['account_title'];
        $staff->bank_account_no = $validatedData['bank_account_no'];
        $staff->bank_name = $validatedData['bank_name'];
        $staff->ifsc_code = $validatedData['ifsc_code'];
        $staff->bank_branch = $validatedData['bank_branch'];
        $staff->payscale = $validatedData['payscale'];
        $staff->basic_salary = $validatedData['basic_salary'];
        $staff->epf_no = $validatedData['epf_no'];
        $staff->contract_type = $validatedData['contract_type'];
        $staff->shift = $validatedData['shift'];
        $staff->location = $validatedData['location'];
        $staff->facebook = $validatedData['facebook'];
        $staff->twitter = $validatedData['twitter'];
        $staff->linkedin = $validatedData['linkedin'];
        $staff->instagram = $validatedData['instagram'];
        $staff->resume = $validatedData['resume'];
        $staff->joining_letter = $validatedData['joining_letter'];
        $staff->resignation_letter = $validatedData['resignation_letter'];
        $staff->other_document_name = $validatedData['other_document_name'];
        $staff->other_document_file = $validatedData['other_document_file'];
        $staff->user_id = $validatedData['user_id'];
        $staff->is_active = $validatedData['is_active'];
        $staff->verification_code = $validatedData['verification_code'];
        $staff->disable_at = $validatedData['disable_at'];
         

        $staff->save();

        return response()->json([
            'success' => true,
            'message' => 'Staff saved successfully',
            'category' => $staff,
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
        $staff = Staff::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

        // Update the category
        $staff->update($validatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $staff,
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
}
