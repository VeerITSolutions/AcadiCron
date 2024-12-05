<?php

namespace App\Http\Controllers;

use App\Models\Feemasters;
use App\Models\FeeGroups;
use App\Models\Feetype;
use App\Models\FeeSessionGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeemastersController extends Controller
{
   /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $id = null)
    {
        // Dynamically fetch the current session (from session or fallback)
        $current_session = session('current_session') ?? 'default_session'; // Replace with your actual logic

        // Get pagination inputs from the request, with defaults
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable max value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Fetch lists of FeeGroups, Feetype, and FeeSessionGroups
        $feegroupList = FeeGroups::latest()->get();
        $feetypeList = Feetype::latest()->get();
        $feemasterList = FeeSessionGroups::all(); // Use ::all() if no custom method is needed

        // Initialize the query for paginated fee data
        $query = DB::table('feemasters')
                    ->join('classes', 'feemasters.class_id', '=', 'classes.id')
                    ->join('feetype', 'feemasters.feetype_id', '=', 'feetype.id')
                    ->select(
                        'feemasters.feetype_id',
                        'feemasters.id',
                        'feemasters.class_id',
                        'feemasters.session_id',
                        'feemasters.amount',
                        'feemasters.description',
                        'classes.class',
                        'feetype.type',
                        'feetype.feecategory_id'
                    )
                    ->where('feemasters.session_id', $current_session);


        // If an ID is provided, fetch single record
        if ($id != null) {
            $data = $query->where('feemasters.id', $id)->first();
            return response()->json([
                'success' => true,
                'data' => $data, // Return the single record
                'message' => 'Data fetched successfully',
            ], 200);
        }

        // For pagination, order by ID and paginate the results
        $data = $query->orderBy('feemasters.id', 'asc')->paginate($perPage, ['*'], 'page', $page);


        // Return the JSON response with paginated data and total counts for each list
        return response()->json([
            'success' => true,
            'data' => [
                'feegroupList' => $feegroupList,
                'feetypeList' => $feetypeList,
                'feemasterList' => $feemasterList,
                'feemasters' => $data->items(), // Paginated fee data
            ],
            'totalCounts' => [
                'feegroupCount' => $feegroupList->count(),
                'feetypeCount' => $feetypeList->count(),
                'feemasterCount' => $feemasterList->count(),
                'feemasterPaginatedCount' => $data->total(), // Total records in the paginated query
            ],
            'rowsPerPage' => $data->perPage(), // Records per page
            'currentPage' => $data->currentPage(), // Current page
            'totalPages' => $data->lastPage(), // Total pages
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
