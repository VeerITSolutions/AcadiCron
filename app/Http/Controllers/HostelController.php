<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelController extends Controller
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
            $data = Hostel::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
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
            $data = Hostel::orderBy('id', 'desc')->get();
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


        // Create a new Hostel
        $Hostel = new Hostel();
        $Hostel->hostel_name = $validatedData['hostel_name'];
        $Hostel->type = $validatedData['type'];
        $Hostel->address = $validatedData['address'];
        $Hostel->intake = $validatedData['intake'];
        $Hostel->description = $validatedData['description'];


        $Hostel->save();

        return response()->json([
            'success' => true,
            'message' => 'Hostel  saved successfully',
            'Hostel' => $Hostel,
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
        // Find the Hostel by id
        $validatedData = $request->all();

        $Hostel = Hostel::findOrFail($id);

        $Hostel->hostel_name = $validatedData['hostel_name'];
        $Hostel->type = $validatedData['type'];
        $Hostel->address = $validatedData['address'];
        $Hostel->intake = $validatedData['intake'];
        $Hostel->description = $validatedData['description'];


        $Hostel->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Hostel' => $Hostel,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the Hostel by ID
            $Hostel = Hostel::findOrFail($id);

            // Delete the Hostel
            $Hostel->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Hostel  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the Hostel was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
