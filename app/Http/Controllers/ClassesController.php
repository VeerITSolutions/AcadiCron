<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request, $id = null, $role = null)
     {
          // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Role ID (replace or customize as per your logic)
    $role_id = 1;

    // Build the query


    $query = DB::table('classes')

    ->select(
       'classes.*'
    );


// Apply pagination
$paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'total' => $paginatedData->total(),
    ], 200);
     }









    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new category
        $category = new Classes();
        $category->class_id = $validatedData['class_id'];
        $category->section_id = $validatedData['section_id'];


        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'class saved successfully',
            'category' => $category,
        ], 201); // 201 Created status code
    }


    public function getClasses(Request $request, $id = null, $role = null)
    {
        // Role ID (use the provided role ID or default to 1)


        // Build the query
        $query = DB::table('classes')

        ->select(
           'classes.*'
        );

        // Get all results
        $results = $query->get();

        // Return the data
        return response()->json([
            'success' => true,
            'data' => $results,
        ], 200);
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
    public function editclasses(Request $request)
    {
         // Extract data from the request
         $name = $request->input('name');
         $id = $request->input('id');
         $sections = $request->input('sections');

         $data_array = [
             'class' => $name
         ];

         // Start a transaction manually
         DB::beginTransaction();

         try {
             // Check if 'id' is set for update or insert
             if (isset($id)) {
                 // Update class
                 $class = Classes::find($id);
                 if ($class) {
                     $class->update($data_array);
                     $class_id = $class->id;

                 }
             } else {
                 // Insert new class
                 $class = Classes::create($data_array);
                 $class_id = $class->id;

             }

             // Prepare data for batch insert into class_sections table
             $sections_array = [];
             foreach ($sections as $vec_value) {
                 $sections_array[] = [
                     'class_id' => $class_id,
                     'section_id' => $vec_value,
                 ];
             }

             // Insert batch data into class_sections table
             ClassSections::insert($sections_array);

             // Commit the transaction if all went well
             DB::commit();

             return response()->json(['success' => 'Record added/updated successfully']);

         } catch (\Exception $e) {
             // Rollback transaction if something went wrong
             DB::rollBack();

             // Return error message
             return response()->json(['error' => $e->getMessage()], 500);
         }
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request,string $id)
    {

        // Find the category by id
        $category = Classes::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

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
            $category = Classes::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'class  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'class  deletion failed: ' . $e->getMessage()], 500);
        }
    }

    public function add(Request $request)
        {
            // Extract data from the request
            $name = $request->input('name');
            $id = $request->input('id');
            $sections = $request->input('sections');

            $data_array = [
                'class' => $name
            ];

            // Start a transaction manually
            DB::beginTransaction();

            try {
                // Check if 'id' is set for update or insert
                if (isset($id)) {
                    // Update class
                    $class = Classes::find($id);
                    if ($class) {
                        $class->update($data_array);
                        $class_id = $class->id;

                    }
                } else {
                    // Insert new class
                    $class = Classes::create($data_array);
                    $class_id = $class->id;

                }

                // Prepare data for batch insert into class_sections table
                $sections_array = [];
                foreach ($sections as $vec_value) {
                    $sections_array[] = [
                        'class_id' => $class_id,
                        'section_id' => $vec_value,
                    ];
                }

                // Insert batch data into class_sections table
                ClassSections::insert($sections_array);

                // Commit the transaction if all went well
                DB::commit();

                return response()->json(['success' => 'Record added/updated successfully']);

            } catch (\Exception $e) {
                // Rollback transaction if something went wrong
                DB::rollBack();

                // Return error message
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
}
