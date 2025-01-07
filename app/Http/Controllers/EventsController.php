<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page'); 
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }

        if($page == null){
            $data = Events::orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $data, 
                'totalCount' => $data->count(), 
                'rowsPerPage' => 1, 
                'currentPage' => 1,
                'message' => '',
            ], 200);
        }
     
        $data = Events::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);


        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data->Events(), 
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
    
        $Events = new Events();
        $Events->event_title = $validatedData['event_title'];
        $Events->event_description = $validatedData['event_description'];
        $Events->start_date = $validatedData['start_date'];
        $Events->end_date = $validatedData['end_date'];
        $Events->event_type = $validatedData['event_type'];
        $Events->event_color = $validatedData['event_color'];
        $Events->event_for = $validatedData['event_for'];
        $Events->role_id = $validatedData['role_id'];
        $Events->is_active = $validatedData['is_active'];
       


    
        $Events->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Events saved successfully',
            'Events' => $Events,
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
        $validatedData = $request->all();

        $Events = Events::findOrFail($id);
        $Events->event_title = $validatedData['event_title'];
        $Events->event_description = $validatedData['event_description'];
        $Events->start_date = $validatedData['start_date'];
        $Events->end_date = $validatedData['end_date'];
        $Events->event_type = $validatedData['event_type'];
        $Events->event_color = $validatedData['event_color'];
        $Events->event_for = $validatedData['event_for'];
        $Events->role_id = $validatedData['role_id'];
        $Events->is_active = $validatedData['is_active'];
        
     
        $Events->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Events' => $Events,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Events = Events::findOrFail($id);

            $Events->delete();

            return response()->json(['success' => true, 'message' => 'Events Category  deleted successfully']);
        } catch (\Exception $e) {
        
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
