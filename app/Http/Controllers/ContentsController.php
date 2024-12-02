<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contents;
use Validator;
use Session;

class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null)
    {
        // Get pagination parameters from the request
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate pagination inputs
        $page = (int) $page;
        $perPage = (int) $perPage;
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Start building the query
        $query = Contents::select(
            'contents.*',
            'classes.class',
            'sections.section',
            \DB::raw('(SELECT GROUP_CONCAT(role) FROM content_for WHERE content_id = contents.id) as role'),
            'class_sections.id as aa'
        )
        ->leftJoin('class_sections', 'contents.cls_sec_id', '=', 'class_sections.id')
        ->leftJoin('classes', 'class_sections.class_id', '=', 'classes.id')
        ->leftJoin('sections', 'class_sections.section_id', '=', 'sections.id')
        ->orderBy('contents.id', 'desc'); // Default ordering

        // If $id is provided, fetch a single record
        if ($id !== null) {
            $result = $query->where('contents.id', $id)->first(); // Fetch a single record
            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => $result, // Return the single content record
                    'message' => 'Data retrieved successfully.',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Content not found.',
                ], 404);
            }
        }

        // If $id is not provided, paginate the results
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->perPage(), // Number of records per page
            'currentPage' => $data->currentPage(), // Current page
            'message' => 'Data retrieved successfully.',
        ], 200);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){

        $validatedData = $request->all();
        $content = new Contents();
        $content->title = $validatedData['title'] ?? "";
        $content->type = $validatedData['type'] ?? "";
        $content->is_public = $validatedData['is_public'] ?? "";
        $content->class_id = $validatedData['class_id'] ?? "";
        $content->cls_sec_id = $validatedData['cls_sec_id'] ?? "";
        $content->created_by = $validatedData['created_by'] ?? 1;
        $content->note = $validatedData['note'] ?? "";
        $content->is_active = $validatedData['is_active'] ?? "";
        $content->created_at = $validatedData['created_at'] ?? now();
        $content->updated_at = $validatedData['updated_at'] ?? now();
        $content->date = $validatedData['date'] ?? "";

        $content->save();

        $content = Contents::findOrFail($content->id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $imageName = $content->id . '_school_content_' . time(); // Example name
            $imageSubfolder = 'school_content/material'; // Example subfolder
            $full_path = 1;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $UpdatevalidatedData["file"] = $imagePath;
        }


        $content->update($UpdatevalidatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Content saved successfully',
            'content' => $content,
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

        // Find the content by id
        $content = Contents::findOrFail($id);
        $validatedData = $request->all();

        // Update the content
        $content->update($validatedData);

        return response()->json([
            'status' => 200,
            'message' => 'Edit successfully',
            'content' => $content,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the content by ID
            $content = Contents::findOrFail($id);

            // Delete the content
            $content->delete();

            // Return success response
            return response()->json(['status' => 200, 'message' => 'content deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the content was not found)
            return response()->json(['status' => 200, 'message' => 'content deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
