<?php

namespace App\Http\Controllers;

use App\Models\FeeSessionGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeSessionGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page'); // Default to page 1 if not provided
        $perPage = $request->input('perPage'); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;



        // Paginate the students data

        if (empty($page)) { // Prepare the response message
            $data = FeeSessionGroups::join('fee_groups', 'fee_session_groups.fee_groups_id', '=', 'fee_groups.id')
                ->select('fee_session_groups.*', 'fee_groups.name as fees_group_name')
                ->get();
            $message = '';

            // Return the paginated data with total count and pagination details
            return response()->json([
                'success' => true,
                'data' => $data, // Only return the current page data

                'message' => $message,
            ], 200);
        } else {
            $data = FeeSessionGroups::join('fee_groups', 'fee_session_groups.fee_groups_id', '=', 'fee_groups.id')
                ->select('fee_session_groups.*', 'fee_groups.name as fees_group_name') // Specify the columns you need from fee_groups
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
    }
    public function getFeesByGroup(Request $request)
    {
        $page = (int) $request->input('page', 1);       // Default to 1
        $perPage = (int) $request->input('perPage', 10); // Default to 10
        $session_id = $request->input('selectedSection'); // Session filter (optional)
        $id = $request->input('id'); // Optional

        $query = DB::table('fee_groups_feetype')
            ->select(
                'fee_groups_feetype.*',
                'fee_groups.name as group_name',
                'feetype.type as feetype_name',
                'feetype.code as feetype_code',
                'fee_session_groups.session_id'
            )
            ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_groups_feetype.fee_groups_id')
            ->join('fee_session_groups', function ($join) {
                $join->on('fee_session_groups.id', '=', 'fee_groups_feetype.fee_session_group_id')
                    ->on('fee_session_groups.fee_groups_id', '=', 'fee_groups_feetype.fee_groups_id');
            })
            ->where('fee_groups.is_system', 0);

        if (!is_null($session_id)) {
            $query->where('fee_session_groups.session_id', $session_id);
        }

        if (!is_null($id)) {
            $query->where('fee_groups_feetype.id', $id);
        }

        $data = $query->orderBy('fee_groups_feetype.id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'totalCount' => $data->total(),
            'rowsPerPage' => $data->lastPage(),
            'currentPage' => $data->currentPage(),
            'message' => 'Fee group feetype list fetched successfully',
        ]);
    }

    /*  public function getFeeTypeByGroup($fee_session_group_id, $fee_group_id)
    {
        return DB::table('fee_groups_feetype')
            ->select('fee_groups_feetype.*', 'feetype.type', 'feetype.code')
            ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
            ->where('fee_groups_feetype.fee_groups_id', $fee_group_id)
            ->where('fee_groups_feetype.fee_session_group_id', $fee_session_group_id)
            ->orderBy('fee_groups_feetype.id', 'asc')
            ->get();
    } */
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        // Validate the incoming request
        $validatedData = $request->validate([
            'house_name' => 'required|string|max:255',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = FeeSessionGroups::where('house_name', $validatedData['house_name'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'house name already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new FeeSessionGroups();
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


    public function update(Request $request, string $id)
    {

        // Find the house_name by id
        $category = FeeSessionGroups::findOrFail($id);

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
            $category = FeeSessionGroups::findOrFail($id);

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
