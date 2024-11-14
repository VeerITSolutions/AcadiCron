<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;



class StaffAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize pagination variables
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
    
        // Validate form input (if required)
        $validator = Validator::make($request->all(), [
            'class_id' => 'nullable|integer',
            'section_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'date' => 'nullable|date',
            'search' => 'nullable|string',
            'holiday' => 'nullable|boolean',
        ]);
    
        // If validation fails, return a validation error response
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    
        // Get filters from the request
        $user_type_id = $request->input('user_id');
        $date = $request->input('date');
        $search = $request->input('search');
        $holiday = $request->input('holiday');
    
        // Initialize the query for retrieving staff attendance
        $query = StaffAttendance::query();
        
        // Apply filters if any
        if ($user_type_id) {
            $query->where('user_type', $user_type_id);
        }
    
        if ($date) {
            $query->whereDate('date', '=', date('Y-m-d', strtotime($date)));
        }
    
        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('staff_id', 'LIKE', "%{$search}%")
                  ->orWhere('remark', 'LIKE', "%{$search}%");
            });
        }
    
        // If holiday filter is provided
        if ($holiday !== null) {
            $query->where('is_holiday', $holiday);
        }
    
        // Apply pagination to the query
        $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Return paginated data with pagination details
        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(), // Current page data
            'current_page' => $paginatedData->currentPage(),
            'per_page' => $paginatedData->perPage(),
            'total' => $paginatedData->total(),
        ], 200);
    }
    
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
