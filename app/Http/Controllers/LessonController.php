<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Paginate the students data
        $data = Lesson::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();

        $class_id = $validatedData['selectedClass'];
        $section_id = $validatedData['selectedSection'];
        $subject_group_id = $validatedData['selectedSubjectGroup'];
        $current_session = $validatedData['currentSessionId'];

        // Create a new lesson



        foreach ($validatedData['name'] as $day) {

            $lesson = new Lesson();

             $lessonLastId =    $lesson->getSubjectGroupClassSectionsId($class_id, $section_id, $subject_group_id , $current_session);



            $lesson->session_id= $current_session;
            $lesson->subject_group_subject_id = $subject_group_id;
            $lesson->subject_group_class_sections_id = $lessonLastId;
            $lesson->name = $day;
            $lesson->save();
        }


        return response()->json([
            'success' => true,
            'message' => 'lesson saved successfully',
            'lesson' => $lesson,
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

        // Find the lesson by id
        $lesson = Lesson::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

        // Update the lesson
        $lesson->update($validatedData);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'lesson' => $lesson,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the lesson by ID
            $lesson = Lesson::findOrFail($id);

            // Delete the lesson
            $lesson->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'lesson deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the lesson was not found)
            return response()->json(['success' => false, 'message' => 'lesson deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
