<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeworkController extends Controller
{
     /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
{
    // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Get filtering inputs from the request
    $class_id = $request->input('class_id');
    $section_id = $request->input('section_id');
    $subject_group_id = $request->input('subject_group_id');
    $subject_id = $request->input('subject_id');

    // Start building the query
    $query = DB::table('homework')
        ->select(
            'classes.class as class_name',
            'sections.section as section_name',
            'homework.*',
            'subject_group_subjects.id as subject_group_subject_id',
            'subjects.name as subject_name',
            'subject_groups.id as subject_groups_id',
            'subject_groups.name as subject_groups_name',
            DB::raw('(select count(*) from submit_assignment where submit_assignment.homework_id = homework.id) as assignments'),
            'staff.name as staff_name',
            'staff.surname as staff_surname'
        )
        ->leftjoin('classes', 'classes.id', '=', 'homework.class_id')
        ->leftjoin('sections', 'sections.id', '=', 'homework.section_id')
        ->leftjoin('subject_group_subjects', 'subject_group_subjects.id', '=', 'homework.subject_group_subject_id')
        ->leftjoin('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
        ->leftjoin('subject_groups', 'homework.subject_group_subject_id', '=', 'subject_groups.id')
        ->leftjoin('staff', 'homework.staff_id', '=', 'staff.id');


    // Apply dynamic filtering based on inputs
    if (!empty($class_id) && !empty($section_id) && !empty($subject_group_id) && !empty($subject_id)) {
        $query->where([
            ['homework.class_id', '=', $class_id],
            ['homework.section_id', '=', $section_id],
            ['subject_groups.id', '=', $subject_group_id],
            ['subject_group_subjects.id', '=', $subject_id],
        ]);
    } elseif (!empty($class_id) && !empty($section_id) && !empty($subject_group_id)) {
        $query->where([
            ['homework.class_id', '=', $class_id],
            ['homework.section_id', '=', $section_id],
            ['subject_groups.id', '=', $subject_group_id],
        ]);
    } elseif (!empty($class_id) && empty($section_id) && empty($subject_id)) {
        $query->where('homework.class_id', '=', $class_id);
    } elseif (!empty($class_id) && !empty($section_id) && empty($subject_id)) {
        $query->where([
            ['homework.class_id', '=', $class_id],
            ['homework.section_id', '=', $section_id],
        ]);
    }

    // Apply sorting
    $paginatedData = $query->orderBy('homework.id', 'asc')->paginate($perPage, ['*'], 'page', $page);


    // Return paginated data with total count and pagination details
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


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new homework
        $homework = new Homework();
        $homework->class_id = $validatedData['selectedClass2'];
        $homework->section_id = $validatedData['selectedSection2'];
        $homework->homework_date = $validatedData['homework_date'];
        $homework->submit_date = $validatedData['submit_date'];
        $homework->description = $validatedData['description'];
        $homework->subject_id = $validatedData['selectedSubject2'];
        $homework->subject_group_subject_id = $validatedData['selectedSubjectGroup2'];
        $homework->session_id = $validatedData['session_id'] ?? 1;
        $homework->staff_id = $validatedData['staff_id'] ?? 1;
        $homework->create_date = $validatedData['create_date'] ?? now();
        $homework->evaluation_date = $validatedData['evaluation_date'] ?? now();
        $homework->created_by = $validatedData['created_by'] ?? 0;
        $homework->evaluated_by = $validatedData['evaluated_by'] ?? 0;






        $file = $request->file('document');
        if($file)
        {
           $imageName = $homework->staff_id .'_document_'. time(); // Example name
           $imageSubfolder = "/homework/assignment/".$homework->staff_id;   // Example subfolder
           $full_path = 0;
           $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
           $homework->document  =  $validatedData['document'] = $imagePath;
        }

        $homework->save();

        return response()->json([
            'success' => true,
            'message' => 'Homework  saved successfully',
            'homework' => $homework,
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
         // Find the homework by id
         $homework = Homework::findOrFail($id);

         // Validate the request data
         $validatedData = $request->validate([
             'selectedClass2' => 'required',
             'selectedSection2' => 'required',
             'homework_date' => 'required|date',
             'submit_date' => 'required|date',
             'description' => 'required|string',
             'selectedSubject2' => 'required',
             'selectedSubjectGroup2' => 'required',
             'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
         ]);

         // Update the homework properties
         $homework->class_id = $validatedData['selectedClass2'];
         $homework->section_id = $validatedData['selectedSection2'];
         $homework->homework_date = $validatedData['homework_date'];
         $homework->submit_date = $validatedData['submit_date'];
         $homework->description = $validatedData['description'];
         $homework->subject_id = $validatedData['selectedSubject2'];
         $homework->subject_group_subject_id = $validatedData['selectedSubjectGroup2'];

         // Handle the file upload if provided
         if ($request->hasFile('document')) {
             $file = $request->file('document');
             $imageName = $homework->staff_id . '_document_' . time(); // Example name
             $imageSubfolder = "/homework/assignment/" . $homework->staff_id; // Example subfolder
             $full_path = 0;
             $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
             $homework->document = $imagePath; // Save the file path to the document field
         }

         // Save the homework updates
         $homework->save();

         return response()->json([
             'success' => true,
             'message' => 'Edit successfully',
             'homework' => $homework,
         ], 200); // 200 OK status code
     }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the homework by ID
            $homework = Homework::findOrFail($id);

            // Delete the homework
            $homework->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Homework  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the homework was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }

}
