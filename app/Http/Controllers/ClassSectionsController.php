<?php

namespace App\Http\Controllers;

use App\Models\ClassSections;
use Illuminate\Http\Request;

class ClassSectionsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Paginate the students data

        $data = ClassSections::join('classes', 'class_sections.class_id', '=', 'classes.id')
        ->join('sections', 'class_sections.section_id', '=', 'sections.id')

        ->select('class_sections.*', 'classes.class as class_name', 'sections.section as section_name') // Specify the columns you need from fee_groups
        ->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->lastPage(), // Total number of pages
            'currentPage' => $data->currentPage(), // Current page
            'message' => $message,
        ], 200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = ClassSections::where('name', $validatedData['name'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'ClassSections name already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new ClassSections();
        $category->name = $validatedData['name'];
        $category->code = $request->code;
        $category->type = $request->type;
        $category->is_active =  $request->is_active ? $request->is_active : 0;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'ClassSections name saved successfully',
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

        // Find the ClassSections_name by id
        $category = ClassSections::findOrFail($id);

       // Validate only the fields you need to validate
            $validatedData = $request->validate([
                'name' => 'required',
            ]);

            // Get the description from the request without validation
            $name = $request->input('name');

            // Merge the validated data with the description
            $updatedData = array_merge($validatedData, [
                'name' => $name,
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
            $category = ClassSections::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'ClassSections name deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'ClassSections name deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
