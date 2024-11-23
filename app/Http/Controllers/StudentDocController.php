<?php

namespace App\Http\Controllers;

use App\Models\SchSettings;
use App\Models\StudentDoc;
use App\Models\Students;
use App\Models\StudentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentDocController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request, $id = null, $role = null)
     {

            $data = DB::table('student_doc')
            ->where('student_id', $request->id)
            ->select('student_doc.*')->get();


                return response()->json([
                    'success' => true,
                    'data' => $data,
                ], 200);
     }


    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();

        $file = $request->file('first_doc');
         if($file)
         {
            $imageName = $request->id .'_student_doc_'. time(); // Example name
            $imageSubfolder = 'student_documents';    // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['doc'] = $imagePath;
         }

        // Create a new category
        $studentdoc = new StudentDoc();


        $studentdoc->student_id = $validatedData['id'];
        $studentdoc->title = $validatedData['title'];
        $studentdoc->doc = $validatedData['doc'];


        $studentdoc->save();

        return response()->json([
            'status' => 200,
            'message' => 'Added successfully',
            'student' => $studentdoc,
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
        $studentdoc = StudentDoc::findOrFail($id);

        $validatedData = $request->all();

        $studentdoc->studentdoc_id = $validatedData['id'];
        $studentdoc->title = $validatedData['title'];

        $file = $request->file('first_doc');
         if($file)
         {
            $imageName = $request->id .'_student_doc_'. time(); // Example name
            $imageSubfolder = 'student_documents';    // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['doc'] = $imagePath;
            $studentdoc->doc = $validatedData['doc'];
         }


        $studentdoc->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $studentdoc,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $studentdoc = StudentDoc::findOrFail($id);

            // Delete the category
            $studentdoc->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
