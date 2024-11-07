<?php

namespace App\Http\Controllers;

use App\Models\Feemasters;
use App\Models\FeeGroups;
use App\Models\Feetype;
use App\Models\FeeSessionGroups;
use Illuminate\Http\Request;

class FeemastersController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch the data
        $feegroupList = FeeGroups::latest()->get();
        $feetypeList = Feetype::latest()->get();
        $feemasterList = FeeSessionGroups::all(); // Use ::all() if no custom method is needed
    
        // Prepare the response data
        $data = [
            'feegroupList' => $feegroupList,
            'feetypeList' => $feetypeList,
            'feemasterList' => $feemasterList,
        ];
    
        // Return JSON response with data and total counts
        return response()->json([
            'success' => true,
            'data' => $data,
            'totalCounts' => [
                'feegroupCount' => $feegroupList->count(),
                'feetypeCount' => $feetypeList->count(),
                'feemasterCount' => $feemasterList->count(),
            ],
            'message' => 'Data retrieved successfully',
        ], 200);
    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){

        // Validate the incoming request
        $validatedData = $request->validate([
            'fees_group' => 'required|string|max:255',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = Feemasters::where('fees_group', $validatedData['fees_group'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'house name already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new Feemasters();
        $category->fees_group = $validatedData['fees_group'];
        $category->fees_type = $request->fees_type;
        $category->due_date = $request->due_date;
        $category->amount = $request->amount;
        $category->fine_type = $request->fine_type;
        $category->percentage = $request->percentage;
        $category->fine_amount = $request->fine_amount;
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
        $category = Feemasters::findOrFail($id);

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
            $category = Feemasters::findOrFail($id);

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
