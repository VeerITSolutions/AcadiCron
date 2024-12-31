<?php

namespace App\Http\Controllers;

use App\Models\HostelRoom;
use App\Models\HostelRoomRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelRoomRoomController extends Controller
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
        $data = HostelRoom::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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


        // Create a new HostelRoom
        $HostelRoom = new HostelRoom();
        $HostelRoom->room_name = $validatedData['room_name'];
        $HostelRoom->no_of_bed = $validatedData['no_of_bed'];
        $HostelRoom->cost_per_bed = $validatedData['cost_per_bed'];
        $HostelRoom->title = $validatedData['title'];
        $HostelRoom->description = $validatedData['description'];


        $HostelRoom->save();

        return response()->json([
            'success' => true,
            'message' => 'HostelRoom  saved successfully',
            'HostelRoom' => $HostelRoom,
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
        // Find the HostelRoom by id
        $validatedData = $request->all();

        $HostelRoom = HostelRoom::findOrFail($id);

        $HostelRoom->room_name = $validatedData['room_name'];
        $HostelRoom->no_of_bed = $validatedData['no_of_bed'];
        $HostelRoom->cost_per_bed = $validatedData['cost_per_bed'];
        $HostelRoom->title = $validatedData['title'];
        $HostelRoom->description = $validatedData['description'];


        $HostelRoom->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'HostelRoom' => $HostelRoom,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the HostelRoom by ID
            $HostelRoom = HostelRoom::findOrFail($id);

            // Delete the HostelRoom
            $HostelRoom->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'HostelRoom  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the HostelRoom was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
