<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
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
         $query = DB::table('topic')
         ->select(
             'topic.*',
             'topic.name',
             'lesson.id as lesson_id'
         )
         ->join('lesson', 'lesson.id', '=', 'topic.lesson_id')

         ->where('topic.session_id', $sessinoId)
         ->orderBy('topic.id', 'desc');
         /* ->groupBy('Topic.subject_group_subject_id', 'Topic.subject_group_class_sections_id'); */

     $data = $query->paginate($perPage, ['*'], 'page', $page);

         // Return paginated response
         return response()->json([
             'success' => true,
             'data' => $data->items(), // Current page data
             'totalCount' => $data->total(), // Total records count
             'rowsPerPage' => $data->perPage(), // Number of rows per page
             'currentPage' => $data->currentPage(), // Current page number
             'message' => 'Topics fetched successfully',
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

             $Topic = new Topic();

             // Retrieve the ID for the subject group class section
             $TopicLastId = $Topic->getSubjectGroupClassSectionsId($class_id, $section_id, $subject_group_id, $current_session);

             if (!$TopicLastId) {
                 return response()->json([
                     'data' => $TopicLastId,
                     'success' => false,
                     'message' => 'Invalid subject group class sections ID. Please check the input data.',
                 ], 400); // 400 Bad Request
             }

             // Verify that the subject_group_class_sections_id exists in the database
             $exists = DB::table('subject_group_class_sections')->where('id', $TopicLastId)->exists();
             if (!$exists) {
                 return response()->json([
                     'success' => false,
                     'message' => 'The subject group class sections ID does not exist in the database.',
                 ], 400);
             }

             // Initialize an array to track created Topics
             $createdTopics = [];
             foreach ($validatedData['name'] as $day) {
                 $newTopic = new Topic();
                 $newTopic->session_id = $current_session;
                 $newTopic->subject_group_subject_id = $selectedSubject;
                 $newTopic->subject_group_class_sections_id = $TopicLastId; // Ensure this is valid
                 $newTopic->name = $day;

                 // Save the new Topic
                 $newTopic->save();
                 $createdTopics[] = $newTopic; // Keep track of created Topics for response
             }

             return response()->json([
                 'success' => true,
                 'message' => 'Topics saved successfully',
                 'Topics' => $createdTopics,
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

             // Find the Topic by id
             $Topic = Topic::findOrFail($id);

             // Validate the request data
             $validatedData = $request->all();

             $class_id = $validatedData['selectedClass'];
             $section_id = $validatedData['selectedSection'];
             $subject_group_id = $validatedData['selectedSubjectGroup'];
             $selectedSubject = $validatedData['selectedSubject'];
             $current_session = $validatedData['currentSessionId'];
             $TopicLastId = $Topic->getSubjectGroupClassSectionsId($class_id, $section_id, $subject_group_id, $current_session);

             foreach ($validatedData['name'] as $name) {



                 $Topic->session_id = $current_session;
                 $Topic->subject_group_subject_id = $selectedSubject;
                 $Topic->subject_group_class_sections_id = $TopicLastId; // Ensure this is valid
                 $Topic->name = $name;

                 // Save the new Topic
                 $Topic->update();

             }


             return response()->json([
                 'success' => true,
                 'message' => 'Edit successfully',
                 'Topic' => $Topic,
             ], 201); // 201 Created status code
         }

         /**
          * Remove the specified resource from storage.
          */
         public function destroy($id)
         {
             try {
                 // Find the Topic by ID
                 $Topic = Topic::findOrFail($id);

                 // Delete the Topic
                 $Topic->delete();

                 // Return success response
                 return response()->json(['success' => true, 'message' => 'Topic deleted successfully']);
             } catch (\Exception $e) {
                 // Handle failure (e.g. if the Topic was not found)
                 return response()->json(['success' => false, 'message' => 'Topic deletion failed: ' . $e->getMessage()], 500);
             }
         }
}
