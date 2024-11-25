<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        // Paginate the students data
        $data = Roles::get();

        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], 200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = Roles::where('name', $validatedData['name'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new Categories();
        $category->category = $validatedData['name'];
        $category->save();

        return response()->json([
            'success' => true,
            'message' => '== saved successfully',
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


    public function update(Request $request,string $id)
    {

        // Find the category by id
        $category = Roles::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',

        ]);

        // Update the category
        $category->update($validatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $category,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = Roles::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Category deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
