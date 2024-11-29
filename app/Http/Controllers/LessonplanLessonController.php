<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Lesson;
use DataTables;
class LessonplanLessonController extends Controller
{
    /**
    * Display a listing of the resource.
    */

    public function index(Request $request, $invoice_id = null, $sub_invoice_id = null)
{
    // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Build the query for 'student_fees_deposite'
    $query = DB::table('student_fees_deposite')
        ->select(
            'student_fees_deposite.*',
            'students.id as std_id',
            'students.firstname',
            'students.middlename',
            'students.lastname',
            'students.admission_no',
            'student_session.class_id',
            'classes.class',
            'sections.section',
            'student_session.section_id',
            'student_session.student_id',
            'fee_groups.name',
            'feetype.type',
            'feetype.code',
            'student_fees_master.student_session_id'
        )
        ->join('fee_groups_feetype', 'fee_groups_feetype.id', '=', 'student_fees_deposite.fee_groups_feetype_id')
        ->join('fee_groups', 'fee_groups.id', '=', 'fee_groups_feetype.fee_groups_id')
        ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
        ->join('student_fees_master', 'student_fees_master.id', '=', 'student_fees_deposite.student_fees_master_id')
        ->join('student_session', 'student_session.id', '=', 'student_fees_master.student_session_id')
        ->join('classes', 'classes.id', '=', 'student_session.class_id')
        ->join('sections', 'sections.id', '=', 'student_session.section_id')
        ->join('students', 'students.id', '=', 'student_session.student_id');

    // Filter by invoice_id if provided
    if ($invoice_id) {
        $query->where('student_fees_deposite.id', $invoice_id);
    }

    // Apply pagination
    $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

    // Filter results based on sub_invoice_id
    $filteredResults = $paginatedData->filter(function ($item) use ($sub_invoice_id) {
        $amount_detail = json_decode($item->amount_detail, true); // Decode JSON to array

        // Check if the sub_invoice_id exists in the amount_detail
        return array_key_exists($sub_invoice_id, $amount_detail);
    });

    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $filteredResults->values(), // Only return the filtered results
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'total' => $paginatedData->total(),
        'last_page' => $paginatedData->lastPage(),
    ], 200);
}





    public function getLessonList(Request $request)
{
    $currentSession = "2023-2024"; //session('current_session');
    $classArray = Classes::pluck('id')->toArray(); // Get class ids

    $result = $this->getLessonListData($currentSession);

    // Ensure $result is properly handled as an object or array
    if (is_array($result)) {
        // If $result is an array
        $draw = isset($result['draw']) ? intval($result['draw']) : 0;
        $recordsTotal = isset($result['recordsTotal']) ? intval($result['recordsTotal']) : 0;
        $recordsFiltered = isset($result['recordsFiltered']) ? intval($result['recordsFiltered']) : 0;
        $data = isset($result['data']) ? $result['data'] : [];
    } elseif (is_object($result)) {
        // If $result is an object
        $draw = isset($result->draw) ? intval($result->draw) : 0;
        $recordsTotal = isset($result->recordsTotal) ? intval($result->recordsTotal) : 0;
        $recordsFiltered = isset($result->recordsFiltered) ? intval($result->recordsFiltered) : 0;
        $data = isset($result->data) ? $result->data : [];
    } else {
        // Handle cases where $result is neither array nor object
        $draw = 0;
        $recordsTotal = 0;
        $recordsFiltered = 0;
        $data = [];
    }

    $dtData = [];

    if (!empty($data)) {
        foreach ($data as $key => $value) {
            $lessonName = '';
            $lesson = Lesson::where('subject_group_subject_id', $value['subject_group_subject_id'])
                            ->where('subject_group_class_sections_id', $value['subject_group_class_sections_id'])
                            ->where('session_id', $currentSession)
                            ->get();

            $editBtn = '';
            $deleteBtn = '';

            // Check permissions
            if (auth()->user()->can('edit', Lesson::class)) {
                $editBtn = '<a href="' . route('lesson.edit', [
                        'section_id' => $value['subject_group_class_sections_id'],
                        'subject_id' => $value['subject_group_subject_id']
                    ]) . '" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>';
            }

            if (auth()->user()->can('delete', Lesson::class)) {
                $deleteBtn = '<a href="javascript:void(0);" onclick="deleteLesson(' . $value['subject_group_class_sections_id'] . ',' . $value['subject_group_subject_id'] . ')" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>';
            }

            if (in_array($value['classid'], $classArray)) {
                foreach ($lesson as $rl_value) {
                    $lessonName .= $rl_value['name'] . '<br>';
                }

                $row = [];
                $row[] = $value['cname'];
                $row[] = $value['sname'];
                $row[] = $value['sgname'];
                $row[] = $value['subname'];
                $row[] = $lessonName;
                $row[] = $editBtn . ' ' . $deleteBtn;

                $dtData[] = $row;
            }
        }
    }

    return response()->json([
        "draw" => $draw,
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data" => $dtData
    ]);
}


    public function getLessonListData($session)
    {
        $query = Lesson::select([
                'lesson.subject_group_subject_id',
                'lesson.subject_group_class_sections_id',
                DB::raw('MAX(subject_groups.name) as sgname'),
                DB::raw('MAX(subjects.name) as subname'),
                DB::raw('MAX(sections.section) as sname'),
                DB::raw('MAX(sections.id) as sectionid'),
                DB::raw('MAX(subject_groups.id) as subjectgroupsid'),
                DB::raw('MAX(subjects.id) as subjectid'),
                DB::raw('MAX(class_sections.id) as csectionid'),
                DB::raw('MAX(classes.class) as cname'),
                DB::raw('MAX(classes.id) as classid')
            ])
            ->join('subject_group_subjects', 'subject_group_subjects.id', '=', 'lesson.subject_group_subject_id')
            ->join('subject_groups', 'subject_groups.id', '=', 'subject_group_subjects.subject_group_id')
            ->join('subjects', 'subjects.id', '=', 'subject_group_subjects.subject_id')
            ->join('subject_group_class_sections', 'subject_group_class_sections.id', '=', 'lesson.subject_group_class_sections_id')
            ->join('class_sections', 'class_sections.id', '=', 'subject_group_class_sections.class_section_id')
            ->join('sections', 'sections.id', '=', 'class_sections.section_id')
            ->join('classes', 'classes.id', '=', 'class_sections.class_id')
            ->where('lesson.session_id', $session)
            ->groupBy('lesson.subject_group_subject_id')
            ->groupBy('lesson.subject_group_class_sections_id');

        return $query->get();
    }





   /**
    * Show the form for creating a new resource.
    */
   public function create(Request $request){


       // Validate the incoming request
       $validatedData = $request->all();


       // Create a new category
       $category = new FeesReminder();
       $category->reminder_type = $validatedData['reminder_type'];
       $category->day = $validatedData['day'];

       $category->is_active = 1;

       $category->save();

       return response()->json([
           'success' => true,
           'message' => 'Fees Reminder saved successfully',
           'category' => $category,
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
       $category = FeesReminder::findOrFail($id);

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
           $category = FeesReminder::findOrFail($id);

           // Delete the category
           $category->delete();

           // Return success response
           return response()->json(['success' => true, 'message' => 'Fees Reminder deleted successfully']);
       } catch (\Exception $e) {
           // Handle failure (e.g. if the category was not found)
           return response()->json(['success' => false, 'message' => 'Fees Reminder  deletion failed: ' . $e->getMessage()], 500);
       }
   }
}
