<?php

namespace App\Http\Controllers;

use App\Models\Certificates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificatesController extends Controller
{
      /**
     * Display a listing of the resource.
     */

   
public function index(Request $request, $id = null, $role = null)
{
    // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Role ID (set this based on your application's needs)
    $role_id = 1;

    // Build the query to retrieve active certificates
    $query = DB::table('certificates')
        ->select('certificates.*')
        ->where('certificates.status', '=', 1);

    // Apply pagination to the query
    $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);

    // Return the response with paginated data
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

        $certificate_name = $request->certificate_name;

        $validatedData = $request->validate([
            'certificate_name' => 'required',
        ]);

        // Check if the category already exists in the Category model
        $existingCategory = Certificates::where('certificate_name', $certificate_name)->first();

    
        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'fees name already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new category
        $category = new Certificates();

        $category->certificate_name= $request->certificate_name;
        $category->certificate_text= $request->certificate_text;
        $category->left_header= $request->left_header;
        $category->center_header= $request->center_header;
        $category->right_header= $request->right_header;
        $category->left_footer= $request->left_footer;
        $category->right_footer= $request->right_footer;
        $category->center_footer= $request->center_footer;
        $category->header_height= $request->header_height;
        $category->content_height= $request->content_height;
        $category->footer_height= $request->footer_height;
        $category->content_width= $request->content_width;
        $category->background_image= $request->background_image;
      
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


    public function update(Request $request,string $id)
    {

        // Find the category by id
        $category = Certificates::findOrFail($id);

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
            $category = Certificates::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Certificates  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
