<?php

namespace App\Http\Controllers;

use App\Models\StudentTimeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTimelineController extends Controller
{

    /**
     * Display a listing of the resource.
     */

     public function index(Request $request, $id = null, $role = null)
     {

            $data = DB::table('student_timeline')
            ->where('student_id', $request->id)
            ->select('student_timeline.*')->get();


                return response()->json([
                    'success' => true,
                    'data' => $data,
                ], 200);
     }


    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();
         // Create a new category */
         $StudentTimeline = new StudentTimeline();


        $file = $request->file('document');
         if($file)
         {
            $imageName = $request->id .'_student_doc_'. time(); // Example name
            $imageSubfolder = 'student_documents';    // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['document'] = $imagePath;
         }




        $StudentTimeline->student_id = $validatedData['id'];
        $StudentTimeline->title = $validatedData['title'];
        $StudentTimeline->timeline_date = $validatedData['timeline_date'];
        $StudentTimeline->description = $validatedData['description'];

        $StudentTimeline->status = 1;
        $StudentTimeline->date = Carbon::now();


        $StudentTimeline->save();

        return response()->json([
            'status' => 200,
            'message' => 'Added successfully',
            'student' => $StudentTimeline,
        ], 201); // 201 Created status code
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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


    public function update(Request $request)
    {
        $id = $request->id;

        // Find the category by id
        $StudentTimeline = StudentTimeline::findOrFail($id);

        $validatedData = $request->all();


        $StudentTimeline->student_id = $validatedData['id'];
        $StudentTimeline->title = $validatedData['title'];
        $StudentTimeline->timeline_date = $validatedData['timeline_date'];
        $StudentTimeline->description = $validatedData['description'];
        $StudentTimeline->status = $validatedData['status'];
        $StudentTimeline->date = Carbon::now();

        $file = $request->file('document');
         if($file)
         {
            $imageName = $request->id .'_student_doc_'. time(); // Example name
            $imageSubfolder = 'student_documents';    // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['document'] = $imagePath;
            $StudentTimeline->document = $validatedData['document'];
         }


        $StudentTimeline->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $StudentTimeline,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $StudentTimeline = StudentTimeline::findOrFail($id);

            // Delete the category
            $StudentTimeline->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
