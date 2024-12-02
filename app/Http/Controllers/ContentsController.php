<?php

namespace App\Http\Controllers;


use App\Models\Contents;
use App\Models\ClassSections;
use Illuminate\Http\Request;

class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null)
    {
        // Get pagination parameters from the request
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate pagination inputs
        $page = (int) $page;
        $perPage = (int) $perPage;
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Start building the query
        $query = Contents::select(
            'contents.*',
            'classes.class',
            'sections.section',
            \DB::raw('(SELECT GROUP_CONCAT(role) FROM content_for WHERE content_id = contents.id) as role'),
            'class_sections.id as aa'
        )
        ->leftJoin('class_sections', 'contents.cls_sec_id', '=', 'class_sections.id')
        ->leftJoin('classes', 'class_sections.class_id', '=', 'classes.id')
        ->leftJoin('sections', 'class_sections.section_id', '=', 'sections.id')
        ->orderBy('contents.id', 'desc'); // Default ordering

        // If $id is provided, fetch a single record
        if ($id !== null) {
            $result = $query->where('contents.id', $id)->first(); // Fetch a single record
        }

        // If $id is not provided, paginate the results
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->perPage(), // Number of records per page
            'currentPage' => $data->currentPage(), // Current page
            'message' => 'Data retrieved successfully.',
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
