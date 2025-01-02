<?php

namespace App\Http\Controllers;


use App\Models\TransportRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportRouteController extends Controller
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
        $data = TransportRoute::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new TransportRoute
        $TransportRoute = new TransportRoute();
        $TransportRoute->route_title = $validatedData['route_title'];
        $TransportRoute->fare = $validatedData['fare'];


        $TransportRoute->save();

        return response()->json([
            'success' => true,
            'message' => 'TransportRoute  saved successfully',
            'TransportRoute' => $TransportRoute,
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
        // Find the TransportRoute by id
        $validatedData = $request->all();

        $TransportRoute = TransportRoute::findOrFail($id);

        $TransportRoute->route_title = $validatedData['route_title'];
        $TransportRoute->fare = $validatedData['fare'];


        $TransportRoute->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'TransportRoute' => $TransportRoute,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the TransportRoute by ID
            $TransportRoute = TransportRoute::findOrFail($id);

            // Delete the TransportRoute
            $TransportRoute->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'TransportRoute  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the TransportRoute was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
