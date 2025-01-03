<?php

namespace App\Http\Controllers;


use App\Models\VehicleRoutes;
use App\Models\Vehicles;
use App\Models\TransportRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleRoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null)
    {
        $current_session = session('current_session') ?? 'default_session'; 
        
        $page = $request->input('page', 1); 
        $perPage = $request->input('perPage', 10); 
        
        $page = (int) $page;
        $perPage = (int) $perPage;
        
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }
    
        // Fetch lists for vehicles and routes
        $vehicleList = Vehicles::latest()->get(); 
        $routeList = TransportRoute::latest()->get(); 
        $vehRouteList = VehicleRoutes::all(); 

        
    
        // Joins with proper table.column references
        $query = VehicleRoutes::join('vehicles', 'vehicle_routes.vehicle_id', '=', 'vehicles.id')
            ->join('transport_route', 'vehicle_routes.route_id', '=', 'transport_route.id')
            ->select(
                'vehicle_routes.*', 
                'vehicles.vehicle_no',
                'transport_route.route_title'
            )
            ->orderBy('vehicle_routes.id', 'desc');
    
        // Fetch specific record if $id is provided
        if ($id !== null) {
            $data = $query->where('vehicle_routes.id', $id)->first();
            
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Data fetched successfully',
            ], 200);
        }
    
        // Paginate results
        $data = $query->paginate($perPage, ['*'], 'page', $page);
    
        return response()->json([
            'success' => true,
            'data' => [
                'vehicleList' => $vehicleList,
                'routeList' => $routeList,
                'vehRouteList' => $vehRouteList,
                'vehRoutes' => $data->items(), 
            ],
            'totalCounts' => [
                'vehicleCount' => $vehicleList->count(),
                'routeCount' => $routeList->count(),
                'vehRouteCount' => $vehRouteList->count(),
                'vehRoutePaginatedCount' => $data->total(), 
            ],
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

        $validatedData = $request->all();

        $vehicleRoutes = new VehicleRoutes();
       
        $vehicleRoutes->route_id = $validatedData['route_id'];
        $vehicleRoutes->vehicle_id = $validatedData['vehicle_id'];

        $vehicleRoutes->save();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle routes saved successfully',
            'Vehicles' => $vehicleRoutes,
        ], 201);
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
    
        $validatedData = $request->all();

        $vehicleRoutes = VehicleRoutes::findOrFail($id);
        $vehicleRoutes->route_id = $validatedData['route_id'];
        $vehicleRoutes->vehicle_id = $validatedData['vehicle_id'];
     
        $vehicleRoutes->update();

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'Vehicles' => $vehicleRoutes,
        ], 200); 
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
     
            $vehicleRoutes = VehicleRoutes::findOrFail($id);

            $vehicleRoutes->delete();

            return response()->json(['success' => true, 'message' => 'Vehicle routes  deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle routes deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
