<?php

namespace App\Http\Controllers;

use App\Models\FeeGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
        $search = $request->input('search');

        $query = DB::table('fee_groups')
            ->select('fee_groups.*')
            ->where('is_system', 0); // Exclude system-defined groups

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $paginatedData = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(),
            'current_page' => $paginatedData->currentPage(),
            'per_page' => $paginatedData->perPage(),
            'total' => $paginatedData->total(),
            'message' => 'Fee groups fetched successfully',
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $name = $request->name;
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        // Check if the category already exists in the Category model
        $existingCategory = FeeGroups::where('name', $name)->first();
        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Fees group already exists',
            ], 409); // 409 Conflict status code
        }
        // Create a new category
        $category = new FeeGroups();
        $category->name = $request->name;
        $category->description = $request->description;
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
        $name = $request->name;
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        // Check if the category already exists in the Category model
        $existingCategory = FeeGroups::where('name', $name)->first();
        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'fees name already exists',
            ], 409); // 409 Conflict status code
        }
        // Create a new category
        $category = new FeeGroups();
        $category->name = $request->name;
        $category->is_active = $request->is_active ?  $request->is_active  : 'no';
        $category->description = $request->description;

        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'fees name saved successfully',
            'category' => $category,
        ], 201); // 201 Created status code
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = DB::table('fee_groups')->where('id', $id)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        return response()->json($item);
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
        $FeeGroups = FeeGroups::findOrFail($id);
        // Validate only the fields you need to validate
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        // Get the description from the request without validation
        $description = $request->input('description');


        $is_active = $request->input('is_active') ?  $request->input('is_active')  : 'no';
        $name = $request->input('name');
        // Merge the validated data with the description
        $updatedData = array_merge($validatedData, [
            'description' => $description,
            'is_active' => $is_active,
            'name' => $name,
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
