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
    $class_id = $request->input('selectedClass');
    $section_id = $request->input('selectedSection');
    $subject_group_id = $request->input('selectedSubjectGroup');
    $subject_id = $request->input('selectedSubject');

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
        ->leftjoin('subject_group_subjects', 'subject_group_subjects.id', '=', 'homework.subject_id')
        ->leftjoin('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
        ->leftjoin('subject_groups', 'homework.subject_group_subject_id', '=', 'subject_groups.id')
        ->leftjoin('staff', 'homework.staff_id', '=', 'staff.id');





    // Apply dynamic filtering based on inputs
    if (!empty($class_id) && !empty($section_id) && !empty($subject_group_id) && !empty($subject_id)) {
        $query->where([
            ['homework.class_id', '=', $class_id],
            ['homework.section_id', '=', $section_id],
            ['homework.subject_group_subject_id', '=', $subject_group_id],
            ['homework.subject_id', '=', $subject_id],
        ]);
    } elseif (!empty($class_id) && !empty($section_id) && !empty($subject_group_id)) {
        $query->where([
            ['homework.class_id', '=', $class_id],
            ['homework.section_id', '=', $section_id],
            ['homework.subject_group_subject_id', '=', $subject_group_id],
        ]);
    } elseif (!empty($class_id) && !empty($section_id) ) {
        $query->where([
            ['homework.class_id', '=', $class_id],
            ['homework.section_id', '=', $section_id],
        ]);
    }elseif (!empty($class_id) ) {
        $query->where([
            ['homework.class_id', '=', $class_id]
        ]);
    }

    // Apply sorting
    $paginatedData = $query->orderBy('homework.id', 'desc')->paginate($perPage, ['*'], 'page', $page);


    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'totalCount' => $paginatedData->total(),
    ], 200);
}



public function searchHomework(Request $request)

{
    $class_id = $request->selectedClass;
    $section_id = $request->selectedSection;
    $subject_group_id = $request->selectedSubjectGroup;
    $subject_id = $request->selectedSubject;

    $query = DB::table('homework')
        ->select(
            'homework.*',
            'classes.class',
            'sections.section',
            'subject_group_subjects.subject_id',
            'subject_group_subjects.id as subject_group_subject_id',
            'subjects.name as subject_name',
            'subject_groups.id as subject_groups_id',
            'subject_groups.name',
            DB::raw('(select count(*) as total from submit_assignment where submit_assignment.homework_id = homework.id) as assignments')
        )
        ->join('classes', 'classes.id', '=', 'homework.class_id')
        ->join('sections', 'sections.id', '=', 'homework.section_id')
        ->join('subject_group_subjects', 'subject_group_subjects.id', '=', 'homework.subject_group_subject_id')
        ->join('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
        ->join('subject_groups', 'subject_group_subjects.subject_group_id', '=', 'subject_groups.id');
        // ->where('subject_groups.session_id', $this->current_session);

    // Add conditional filters
    if (!empty($class_id) && !empty($section_id) && !empty($subject_id) && !empty($subject_group_id)) {
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

    $query->orderBy('homework.homework_date', 'DESC');
    $homeworks = $query->get();

    // Add count_percentage logic
    $resultlist = [];
    foreach ($homeworks as $homework) {
        $report = $this->countPercentage($homework->id, $homework->class_id, $homework->section_id);
        $homework->report = $report;
        $resultlist[] = $homework;
    }

    return response()->json([
        'success' => true,
        'data' => $resultlist
    ], 200);
}

public function countPercentage($id, $class_id, $section_id)
{
    $data = [];

    $total_students = $this->countStudents($class_id, $section_id);
    $count_evalstudents = $this->countEvalStudents($id, $class_id, $section_id);

    if ($total_students > 0) {
        $completed = $count_evalstudents->total; // Use object syntax
        $percentage = ($completed / $total_students) * 100;

        $data['total'] = $total_students;
        $data['completed'] = $completed;
        $data['percentage'] = round($percentage, 2);
    }

    return $data;
}

public function countStudents($class_id, $section_id)
{
    return DB::table('students')
        ->join('student_session', 'students.id', '=', 'student_session.student_id')
        ->where([
            ['student_session.class_id', '=', $class_id],
            ['student_session.section_id', '=', $section_id],
            ['students.is_active', '=', 'yes'],
            // ['student_session.session_id', '=', $this->current_session],
        ])
        ->groupBy('student_session.student_id')
        ->count();
}

public function countEvalStudents($id, $class_id, $section_id)
{
    return DB::table('homework')
        ->select(DB::raw('count(*) as total'))
        ->join('homework_evaluation', 'homework_evaluation.homework_id', '=', 'homework.id')
        ->join('student_session', 'student_session.id', '=', 'homework_evaluation.student_session_id')
        ->join('students', 'students.id', '=', 'student_session.student_id')
        ->where([
            ['homework.id', '=', $id],
            // ['homework.session_id', '=', $this->current_session],
            ['students.is_active', '=', 'yes'],
        ])
        ->first();
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

         $validatedData = $request->all();



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
         $homework->update();

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
