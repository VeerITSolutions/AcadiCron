<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
     /**
     * Display a listing of the resource.
     */



    public function index(Request $request)
{
    $page = $request->input('page', 1); // Default to page 1 if not provided
    $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided
    $sessinoId = $request->input('sessionId');
    // Validate the inputs
    $page = (int) $page;
    $perPage = (int) $perPage;

    if ($perPage <= 0 || $perPage > 100) {
        $perPage = 10; // Default value if invalid
    }

    // Query using Eloquent with joins and relationships
    $query = DB::table('lesson')
    ->select(
        'lesson.id',
        'lesson.name',
        'lesson.subject_group_subject_id',
        'lesson.subject_group_class_sections_id',
        'subject_groups.name as sgname',
        'subjects.name as subname',
        'sections.section as sname',
        'sections.id as sectionid',
        'subject_groups.id as subjectgroupsid',
        'subjects.id as subjectid',
        'class_sections.id as csectionid',
        'classes.class as cname',
        'classes.id as classid'
    )
    ->join('subject_group_subjects', 'subject_group_subjects.id', '=', 'lesson.subject_group_subject_id')
    ->join('subject_groups', 'subject_groups.id', '=', 'subject_group_subjects.subject_group_id')
    ->join('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
    ->join('subject_group_class_sections', 'subject_group_class_sections.id', '=', 'lesson.subject_group_class_sections_id')
    ->join('class_sections', 'class_sections.id', '=', 'subject_group_class_sections.class_section_id')
    ->join('sections', 'sections.id', '=', 'class_sections.section_id')
    ->join('classes', 'classes.id', '=', 'class_sections.class_id')
    ->where('lesson.session_id', $sessinoId);
    /* ->groupBy('lesson.subject_group_subject_id', 'lesson.subject_group_class_sections_id'); */

$data = $query->paginate($perPage, ['*'], 'page', $page);

    // Return paginated response
    return response()->json([
        'success' => true,
        'data' => $data->items(), // Current page data
        'totalCount' => $data->total(), // Total records count
        'rowsPerPage' => $data->perPage(), // Number of rows per page
        'currentPage' => $data->currentPage(), // Current page number
        'message' => 'Lessons fetched successfully',
    ], 200);
}




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->all();

        $class_id = $validatedData['selectedClass'];
        $section_id = $validatedData['selectedSection'];
        $subject_group_id = $validatedData['selectedSubjectGroup'];
        $selectedSubject = $validatedData['selectedSubject'];
        $current_session = $validatedData['currentSessionId'];

        $lesson = new Lesson();

        // Retrieve the ID for the subject group class section
        $lessonLastId = $lesson->getSubjectGroupClassSectionsId($class_id, $section_id, $subject_group_id, $current_session);

        if (!$lessonLastId) {
            return response()->json([
                'data' => $lessonLastId,
                'success' => false,
                'message' => 'Invalid subject group class sections ID. Please check the input data.',
            ], 400); // 400 Bad Request
        }

        // Verify that the subject_group_class_sections_id exists in the database
        $exists = DB::table('subject_group_class_sections')->where('id', $lessonLastId)->exists();
        if (!$exists) {
            return response()->json([
                'success' => false,
                'message' => 'The subject group class sections ID does not exist in the database.',
            ], 400);
        }

        // Initialize an array to track created lessons
        $createdLessons = [];
        foreach ($validatedData['name'] as $day) {
            $newLesson = new Lesson();
            $newLesson->session_id = $current_session;
            $newLesson->subject_group_subject_id = $selectedSubject;
            $newLesson->subject_group_class_sections_id = $lessonLastId; // Ensure this is valid
            $newLesson->name = $day;

            // Save the new lesson
            $newLesson->save();
            $createdLessons[] = $newLesson; // Keep track of created lessons for response
        }

        return response()->json([
            'success' => true,
            'message' => 'Lessons saved successfully',
            'lessons' => $createdLessons,
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
