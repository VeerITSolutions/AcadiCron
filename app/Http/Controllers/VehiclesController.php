<?php

namespace App\Http\Controllers;


use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); 
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }

        $data = Vehicles::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data->items(), 
            'totalCount' => $data->total(), 
            'rowsPerPage' => $data->lastPage(),
            'currentPage' => $data->currentPage(), 
            'message' => $message,
        ], 200);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        $validatedData = $request->all();

        $Vehicles = new Vehicles();
       
        $Vehicles->vehicle_no = $validatedData['vehicle_no'];
        $Vehicles->vehicle_model = $validatedData['vehicle_model'];
        $Vehicles->manufacture_year = $validatedData['manufacture_year'];
        $Vehicles->driver_name = $validatedData['driver_name'];
        $Vehicles->driver_licence = $validatedData['driver_licence'];
        $Vehicles->driver_contact = $validatedData['driver_contact'];
        $Vehicles->note = $validatedData['note'];

        $Vehicles->save();

        return response()->json([
            'success' => true,
            'message' => 'Vehicles  saved successfully',
            'Vehicles' => $Vehicles,
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

        $Vehicles = Vehicles::findOrFail($id);
        $Vehicles->vehicle_no = $validatedData['vehicle_no'];
        $Vehicles->vehicle_model = $validatedData['vehicle_model'];
        $Vehicles->manufacture_year = $validatedData['manufacture_year'];
        $Vehicles->driver_name = $validatedData['driver_name'];
        $Vehicles->driver_licence = $validatedData['driver_licence'];
        $Vehicles->driver_contact = $validatedData['driver_contact'];
        $Vehicles->note = $validatedData['note'];

        $Vehicles->update();

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'Vehicles' => $Vehicles,
        ], 200); 
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
     
            $Vehicles = Vehicles::findOrFail($id);

            $Vehicles->delete();

            return response()->json(['success' => true, 'message' => 'Vehicles  deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Vehicles deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
