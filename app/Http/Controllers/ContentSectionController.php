<?php

namespace App\Http\Controllers;

use App\Models\ContentFor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request, $id = null, $role = null)
     {
         // Start building the query
         $query = DB::table('content_for')
             ->select(
                 'contents.*',
                 DB::raw("(SELECT GROUP_CONCAT(role) FROM content_for WHERE content_id=contents.id) as role"),
                 'class_sections.id as class_section_id',
                 'classes.class',
                 'sections.section'
             )
             ->leftJoin('contents', 'content_for.content_id', '=', 'contents.id')
             ->leftJoin('class_sections', 'class_sections.id', '=', 'contents.cls_sec_id')
             ->leftJoin('classes', 'classes.id', '=', 'class_sections.class_id')
             ->leftJoin('sections', 'sections.id', '=', 'class_sections.section_id')
             ->groupBy('contents.id');
     
         // Add role conditions based on the provided role and ID
        //  if ($role === 'student') {
        //      $query->where(function($q) use ($id, $role) {
        //          $q->where('role', 'student')
        //            ->where('created_by', $id)
        //            ->orWhere(function($q) use ($role) {
        //                $q->where('created_by', 0)
        //                  ->where('role', $role);
        //            });
        //      });
        //  } elseif ($role === 'Teacher') {
        //      $query->where(function($q) use ($id, $role) {
        //          $q->where('role', 'Teacher')
        //            ->where('created_by', $id)
        //            ->orWhere(function($q) use ($role) {
        //                $q->where('created_by', 0)
        //                  ->where('role', $role);
        //            });
        //      });
        //  }
     
         // You can also process additional filters from the request, if needed
         // Example: adding more filtering conditions based on request parameters
         if ($request->has('filter')) {
             $filter = $request->input('filter');
             // Apply more filters here based on the request data
         }
     
         // Execute the query and return the results, converting them to an array
         $contents = $query->get()->toArray();
     
         // Return the results, possibly in JSON format or passed to a view
         return response()->json($contents);
     }
     



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            
        ]);
    
        // Create a new SendNotification
        $notification = new ContentFor();
        $notification->fill($validatedData);
        $notification->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Notification saved successfully',
            'notification' => $notification,
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
        $category = ContentFor::findOrFail($id);

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
            $category = ContentFor::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Notification  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
