<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeesDiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null, $role = null)
    {
        // Get pagination inputs, default to page 1 and 10 records per page if not provided
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
        $order = $request->input('order', 'desc'); // Default order to 'desc' unless provided
    
        // Build the base query for 'fees_discounts' table
        $query = DB::table('fees_discounts');
    
        // If ID is provided, retrieve the specific row
        if ($id !== null) {
            $query->where('id', $id);
            $record = $query->first(); // Get single record for specific ID
    
            // Return single record without pagination
            return response()->json([
                'success' => true,
                'data' => $record,
            ], 200);
        } else {
            // Apply ordering and proceed with pagination for multiple records
            $query->orderBy('id', $order);
    
            // Paginate the query
            $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);
    
            // Return paginated data with pagination details
            return response()->json([
                'success' => true,
                'data' => $paginatedData->items(), // Only return the current page data
                'current_page' => $paginatedData->currentPage(),
                'per_page' => $paginatedData->perPage(),
                'total' => $paginatedData->total(),
                'last_page' => $paginatedData->lastPage(),
                'next_page_url' => $paginatedData->nextPageUrl(),
                'prev_page_url' => $paginatedData->previousPageUrl(),
            ], 200);
        }
    }
    




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){

  
        $type = $request->type;

        $validatedData = $request->validate([
            'type' => 'required',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = Feetype::where('type', $type)->first();

    
        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'fees name already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new Feetype();
        $category->is_system= 0;
        $category->type= $request->type;
        $category->feecategory_id= $request->feecategory_id ? $request->feecategory_id : null ;

        $category->code= $request->code;
        $category->is_active = $request->is_active ?  $request->is_active  : 'no';
        $category->description= $request->description;
      

       
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'fees name saved successfully',
            'category' => $category,
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
