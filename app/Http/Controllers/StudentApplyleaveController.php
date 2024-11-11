<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Classes;
use App\Models\SchSettings;

class StudentApplyleaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
    
        // Initialize pagination variables
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
    
        // Validate form input
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
        ]);
    
        // Start building the query for ApplyLeaveModel
        $query = DB::table('student_applyleave') // Replace with the actual table name
                   ->select('student_applyleave.*') // Specify the columns as needed
                   ->orderBy('student_applyleave.created_at', 'desc');
    
        // Apply filters if validation passes
        if (!$validator->fails()) {
            $class_id = $request->input('class_id');
            $section_id = $request->input('section_id');

        }
    
        // Apply pagination
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
