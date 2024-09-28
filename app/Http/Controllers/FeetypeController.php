<?php

namespace App\Http\Controllers;

use App\Models\Feetype;
use Illuminate\Http\Request;

class FeetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Fetch all Feetype records
    $data = Feetype::all();

    // Prepare the response message (optional)
    $message = '';

    // Return all the records
    return response()->json([
        'success' => true,
        'data' => $data, // Return all the data
        'totalCount' => $data->count(), // Total number of records
        'message' => $message,
    ], 200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->validate([
            'house_name' => 'required|string|max:255',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = Feetype::where('house_name', $validatedData['house_name'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'house name already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new Feetype();
        $category->house_name = $validatedData['house_name'];
        $category->description = $request->description;
        $category->is_active = 0;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'house name saved successfully',
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

        // Find the house_name by id
        $category = Feetype::findOrFail($id);

       // Validate only the fields you need to validate
            $validatedData = $request->validate([
                'house_name' => 'required',
            ]);

            // Get the description from the request without validation
            $description = $request->input('description');

            // Merge the validated data with the description
            $updatedData = array_merge($validatedData, [
                'description' => $description,
            ]);

        // Update the category
        $category->update($updatedData);




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
            $category = Feetype::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'house name deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'house name deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
