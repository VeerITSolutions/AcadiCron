<?php

namespace App\Http\Controllers;

use App\Models\HostelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostelRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided
    
        $page = (int) $page;
        $perPage = (int) $perPage;
    
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }
    
        $data = VehicleRoutes::leftJoin('vehicles', 'vehicle_routes.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('transport_route', 'vehicle_routes.route_id', '=', 'transport_route.id')
            ->orderBy('vehicle_routes.id', 'desc')
            ->paginate(
                $perPage,
                ['vehicle_routes.*', 'vehicles.vehicle_no as vehicle_no', 'transport_route.route_title as route_title'],
                'page',
                $page
            );
    
        return response()->json([
            'success' => true,
            'data' => $data->items(), 
            'totalCount' => $data->total(), 
            'rowsPerPage' => $data->perPage(), 
            'currentPage' => $data->currentPage(), 
            'totalPages' => $data->lastPage(), 
            'message' => 'Data retrieved successfully',
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
        $HostelRoom->room_type_id = $validatedData['room_type_id'];
        $HostelRoom->hostel_id = $validatedData['hostel_id'];
        $HostelRoom->room_no = $validatedData['room_no'];
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

        $HostelRoom->room_type_id = $validatedData['room_type_id'];
        $HostelRoom->hostel_id = $validatedData['hostel_id'];
        $HostelRoom->room_no = $validatedData['room_no'];
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
