<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\ContentFor;
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
        // Get pagination parameters from the request with default values
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
        $class_id = $request->input('class_id');
        $section_id = $request->input('section_id');
        $type = $request->input('type'); // Default to 10 records

        // Validate perPage value to prevent excessive queries
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }

        // Start building the query
        $query = Contents::select(
            'contents.*',
            'classes.class',
            'sections.section',
            \DB::raw('(SELECT GROUP_CONCAT(role) FROM content_for WHERE content_id = contents.id) as roles')
        )
            ->leftJoin('class_sections', 'contents.cls_sec_id', '=', 'class_sections.id')
            ->leftJoin('classes', 'class_sections.class_id', '=', 'classes.id')
            ->leftJoin('sections', 'class_sections.section_id', '=', 'sections.id')
            ->orderBy('contents.id', 'desc');

        // Apply filters
        if (!empty($class_id)) {
            $query->where('contents.class_id', $class_id);
        }
        if (!empty($section_id)) {
            $query->where('contents.cls_sec_id', $section_id);
        }
        if ($type) {
            $query->where('contents.type', $type);
        }
        // Fetch a single record if ID is provided
        if ($id !== null) {
            $result = $query->where('contents.id', $id)->first();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => $result,
                    'message' => 'Data retrieved successfully.',
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Content not found.',
            ], 404);
        }

        // Paginate the results
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'totalCount' => $data->total(),
            'rowsPerPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'message' => 'Data retrieved successfully.',
        ], 200);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validatedData = $request->except(['allsuperadmin', 'allstudents', 'allclasses', 'role']);

        $onlyvalidatedData = $request->only(['allsuperadmin', 'allstudents', 'allclasses', 'role']);


        $content = new Contents();
        $content->title = $validatedData['title'] ?? "";
        $content->type = $validatedData['type'] ?? "";
        $content->is_public = $validatedData['is_public'] ?? "";
        $content->class_id = $validatedData['class_id'];
        $content->cls_sec_id = $validatedData['cls_sec_id'];
        $content->created_by = $validatedData['created_by'] ?? 1;
        $content->note = $validatedData['note'] ?? "";
        $content->is_active = $validatedData['is_active'] ?? "";
        $content->created_at = $validatedData['created_at'] ?? now();
        $content->updated_at = $validatedData['updated_at'] ?? now();
        $content->date = $validatedData['date'] ?? "";


        $content->created_at = $validatedData['created_at'] ?? now();
        $content->updated_at = $validatedData['updated_at'] ?? now();
        $content->date = $validatedData['date'] ?? "";

        $content->save();
        /* content for  */

        /* added content for  */
        $content_for = new ContentFor();



        if ($onlyvalidatedData['allsuperadmin'] == "true") {
            $content_for->role = 'All Super Admin';
        } else if ($onlyvalidatedData['allstudents'] == "true") {

            $content_for->role = 'All Student';
        } elseif ($onlyvalidatedData['allclasses'] == "true") {
            $content_for->role = 'All Classes';
        } else {
            $content_for->role = 'Students';
        }



        $content_for->content_id = $content->id ?? "";


        $content_for->user_id = null;

        $content_for->created_at = $onlyvalidatedData['created_at'] ?? now();

        $content_for->save();



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
    public function update(Request $request, string $id)
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

            $content_for = ContentFor::where('content_id', $id)->delete();

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
