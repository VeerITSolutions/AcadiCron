<?php

namespace App\Http\Controllers;

use App\Models\FeeGroups;
use Illuminate\Http\Request;

class FeeGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Feegroups::latest()->get();
        

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
        $type = $request->type;
        $validatedData = $request->validate([
            'type' => 'required',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = FeeGroups::where('type', $type)->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Fees group already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new FeeGroups();
        $category->type= $request->type;
        $category->is_system= 0;
        $category->description= $request->description;
        $category->feecategory_id= $request->feecategory_id ? $request->feecategory_id : null ;
        $category->code= $request->code;
        $category->is_active = $request->is_active ?  $request->is_active  : 'no';
        $category->save();


       

        return response()->json([
            'success' => true,
            'message' => 'Fees group saved successfully',
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
        $FeeGroups = FeeGroups::findOrFail($id);

       // Validate only the fields you need to validate
            $validatedData = $request->validate([
                'type' => 'required',
            ]);

            // Get the description from the request without validation
            $description = $request->input('description');
            $is_active = $request->input('is_active');
            $type = $request->input('type');

            

            // Merge the validated data with the description
            $updatedData = array_merge($validatedData, [
           
                'description' => $description,
                'is_active' => $is_active,
                'type' => $type,
            ]);

        // Update the category
        $FeeGroups->update($updatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $FeeGroups,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = FeeGroups::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Fees group deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Fees group deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
