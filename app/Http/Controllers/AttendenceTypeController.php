<?php

namespace App\Http\Controllers;

use App\Models\AttendenceType;
use Illuminate\Http\Request;

class AttendenceTypeController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page'); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Paginate the students data

        if ($page) {
            $data = AttendenceType::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
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
        } else {
            $data = AttendenceType::orderBy('id', 'desc')->get();
            $message = '';

            // Return the paginated data with total count and pagination details
            return response()->json([
                'success' => true,
                'data' => $data, // Only return the current page data
            ], 200);
        }
        // Prepare the response message
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new AttendenceType
        $AttendenceType = new AttendenceType();
        $AttendenceType->type = $validatedData['type'];
        $AttendenceType->key_value = $validatedData['key_value'];
        $AttendenceType->is_active = $validatedData['is_active'];


        $AttendenceType->save();

        return response()->json([
            'success' => true,
            'message' => 'saved successfully',
            'AttendenceType' => $AttendenceType,
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
        // Find the AttendenceType by id
        $validatedData = $request->all();

        $AttendenceType = AttendenceType::findOrFail($id);

        $AttendenceType->type = $validatedData['type'];
        $AttendenceType->key_value = $validatedData['key_value'];
        $AttendenceType->is_active = $validatedData['is_active'];


        $AttendenceType->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'AttendenceType' => $AttendenceType,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the AttendenceType by ID
            $AttendenceType = AttendenceType::findOrFail($id);

            // Delete the AttendenceType
            $AttendenceType->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'AttendenceType  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the AttendenceType was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
