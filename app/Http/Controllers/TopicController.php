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



         $query = DB::table('topic')
         ->select(
             'topic.*',
             'subject_groups.name as sgname',
             'subjects.name as subname',
             'sections.section as sname',
             'sections.id as sectionid',
             'subject_groups.id as subjectgroupsid',
             'subjects.id as subjectid',
             'class_sections.id as csectionid',
             'classes.class as cname',
             'classes.id as classid',
             'lesson.name as lessonname',
             'lesson.subject_group_class_sections_id',
             'lesson.subject_group_subject_id'
         )
         ->join('lesson', 'lesson.id', '=', 'topic.lesson_id')
         ->join('subject_group_subjects', 'subject_group_subjects.id', '=', 'lesson.subject_group_subject_id')
         ->join('subject_groups', 'subject_groups.id', '=', 'subject_group_subjects.subject_group_id')
         ->join('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
         ->join('subject_group_class_sections', 'subject_group_class_sections.id', '=', 'lesson.subject_group_class_sections_id')
         ->join('class_sections', 'class_sections.id', '=', 'subject_group_class_sections.class_section_id')
         ->join('sections', 'sections.id', '=', 'class_sections.section_id')
         ->join('classes', 'classes.id', '=', 'class_sections.class_id')
         ->where('topic.session_id', $sessinoId)
         ->orderBy('topic.id', 'desc');

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




            $validatedData = $request->all();

            $lessonId = $validatedData['lessonId'];
            $current_session = $validatedData['currentSessionId'];


            foreach ($validatedData['name'] as $name) {
                $Topic = new Topic();
                $Topic->session_id = $current_session;
                $Topic->lesson_id = $lessonId;
                $Topic->complete_date =  now();
                $Topic->status = 0;
                $Topic->name = $name;
                $Topic->save();

            }


            return response()->json([
                'success' => true,
                'message' => 'Added successfully',
                'Topic' => $Topic,
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



             $lessonId = $validatedData['lessonId'];
             $current_session = $validatedData['currentSessionId'];


             foreach ($validatedData['name'] as $name) {



                 $Topic->session_id = $current_session;
                 $Topic->lesson_id = $lessonId;
                 $Topic->complete_date =  now();
                 $Topic->status = 0; // Ensure this is valid
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
