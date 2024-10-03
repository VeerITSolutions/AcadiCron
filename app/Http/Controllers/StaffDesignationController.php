<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffDesignation;
use Illuminate\Support\Facades\DB; // Import the DB facade

class StaffDesignationController extends Controller


{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate and sanitize inputs
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is within reasonable limits
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default to 10 if invalid
        }

        // Paginate the staff_designation data
        $data = DB::table('staff_designation')
            ->where('is_active', 'yes') // Fetch only active records
            ->paginate($perPage, ['*'], 'page', $page);

        // Prepare the response message if needed
        $message = '';

        // Return the paginated data with pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Return only the current page's data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->perPage(), // Number of records per page
            'currentPage' => $data->currentPage(), // Current page
            'message' => $message,
        ], 200);
    }
    

    /**
     * Show the form for creating a new resource.
     */

     
    public function create(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'designation' => 'required|string|max:255',
        ]);
    
        // Check if the designation already exists
        $existingCategory = StaffDesignation::where('designation', $validatedData['designation'])->first();
    
        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Designation name already exists',
            ], 409); // 409 Conflict status code
        }
    
        // Create a new designation
        $category = new StaffDesignation();
        $category->designation = $validatedData['designation'];
        $category->is_active = $request->is_active ?  $request->is_active  : 'yes';
        $category->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Designation name saved successfully',
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
    public function update(Request $request, string $id)
    {
        // Attempt to find the category
        $category = StaffDesignation::find($id);
    
        // Check if the category was found
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Staff designation not found',
            ], 404); // 404 Not Found status code
        }
    
        // Validate the fields you need to validate
        $validatedData = $request->validate([
            'designation' => 'required',
        ]);
    
        // Update the category with validated data
        $category->update($validatedData);
    
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Edit successful',
            'category' => $category,
        ], 200); // 200 OK status code
    }
    
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = StaffDesignation::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Designation name deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Designation name deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
