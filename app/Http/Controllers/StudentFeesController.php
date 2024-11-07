<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Add this line
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class StudentFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null, $role = null)
    {
        // Check if a user is authenticated and has privilege
        $user = auth()->user();
        if (!$user || !$user->hasPrivilege('collect_fees', 'can_view')) {
            // Return a generic response without indicating access denial
            return response()->json([
                'success' => true,
                'data' => [
                    'students' => [],
                    'sch_setting' => null,
                    'classlist' => [],
                ],
                'current_page' => 1,
                'per_page' => 10,
                'total' => 0,
            ], 200);
        }
    
        // Set session data for menus
        Session::put('top_menu', __('fees_collection'));
        Session::put('sub_menu', 'studentfee/index');
    
        // Pagination inputs with defaults
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
    
        // Fetch school settings and classes
        $sch_setting = $this->sch_setting_detail;
        $classlist = $this->class_model->get();
    
        // Build the query
        $query = DB::table('students')
            ->select('students.*');
    
        // Apply pagination
        $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Return JSON response with paginated data and additional information
        return response()->json([
            'success' => true,
            'data' => [
                'students' => $paginatedData->items(),
                'sch_setting' => $sch_setting,
                'classlist' => $classlist,
            ],
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
