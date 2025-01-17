<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateAdmitcards;
use Illuminate\Support\Facades\DB;

class TemplateAdmitcardsController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
    
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }
    
        $data = TemplateAdmitcards::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    
        $message = 'Data fetched successfully';
    
        return response()->json([
            'success' => true,
            'data' => $data->items(), 
            'totalCount' => $data->total(), 
            'rowsPerPage' => $data->perPage(), 
            'currentPage' => $data->currentPage(), 
            'message' => $message,
        ], 200);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $validatedData = $request->all();

    $existingAdmitcard = TemplateAdmitcards::where('template', $validatedData['template'])->first();

    if ($existingAdmitcard) {
        return response()->json([
            'success' => false,
            'message' => 'Template already exists',
        ], 409); 
    }

    $admitcard = new TemplateAdmitcards();

    $admitcard->template = $validatedData['template'];
    $admitcard->heading = $validatedData['heading'] ?? null;
    $admitcard->title = $validatedData['title'] ?? null;
    $admitcard->left_logo = $validatedData['left_logo'] ?? null;
    $admitcard->right_logo = $validatedData['right_logo'] ?? null;
    $admitcard->exam_name = $validatedData['exam_name'] ?? null;
    $admitcard->school_name = $validatedData['school_name'] ?? null;
    $admitcard->exam_center = $validatedData['exam_center'] ?? null;
    $admitcard->sign = $validatedData['sign'] ?? null;
    $admitcard->background_img = $validatedData['background_img'] ?? null;
    $admitcard->is_name = ($validatedData['is_name'] === 'false' || !$validatedData['is_name']) ? 0 : 1;
    $admitcard->is_father_name = ($validatedData['is_father_name'] === 'false' || !$validatedData['is_father_name']) ? 0 : 1;
    $admitcard->is_mother_name = ($validatedData['is_mother_name'] === 'false' || !$validatedData['is_mother_name']) ? 0 : 1;
    $admitcard->is_dob = ($validatedData['is_dob'] === 'false' || !$validatedData['is_dob']) ? 0 : 1;
    $admitcard->is_admission_no = ($validatedData['is_admission_no'] === 'false' || !$validatedData['is_admission_no']) ? 0 : 1;
    $admitcard->is_roll_no = ($validatedData['is_roll_no'] === 'false' || !$validatedData['is_roll_no']) ? 0 : 1;
    $admitcard->is_address = ($validatedData['is_address'] === 'false' || !$validatedData['is_address']) ? 0 : 1;
    $admitcard->is_gender = ($validatedData['is_gender'] === 'false' || !$validatedData['is_gender']) ? 0 : 1;
    $admitcard->is_photo = ($validatedData['is_photo'] === 'false' || !$validatedData['is_photo']) ? 0 : 1;
    $admitcard->is_class = ($validatedData['is_class'] === 'false' || !$validatedData['is_class']) ? 0 : 1;
    $admitcard->is_section = ($validatedData['is_section'] === 'false' || !$validatedData['is_section']) ? 0 : 1;
    $admitcard->content_footer = $validatedData['content_footer'] ?? null;
    

 
    $file = $request->file('background_img');
    if ($file) {
        $imageName = $admitcard->staff_id . '_document_' . time(); // Example name
        $imageSubfolder = "/Admitcard/" . $admitcard->staff_id; // Example subfolder
        $full_path = 0;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $admitcard->background_img = $imagePath;
    } else {
        $admitcard->background_img = ''; // Provide a default value if no image is uploaded
    }

    $admitcard->save();

    return response()->json([
        'success' => true,
        'message' => 'Admitcard created successfully',
        'admitcard' => $admitcard,
    ], 201);
}



public function AdmitcardView(Request $request, string $id)
{

    // Ensure you actually use the `$id` value from the request
    if (!$id) {
        return response()->json(['error' => 'Invalid Admitcard ID'], 400);
    }

    $admitcard = DB::table('template_admitcards')->where('id', $id)->first();

    if (!$admitcard) {
        return response()->json(['error' => 'Admitcard not found'], 404);
    }

    $data = [
        'Admitcard' => $admitcard,
    ];
    $idsToGenerate = $request->idsToGenerate;
    if($idsToGenerate){

        $data['studentDatas']  = Students::whereIn('id', $idsToGenerate)->get();

    $preview = view('admin.admitcard.createadmitcard', $data)->render();
    }else{
         // Render the preview view and return it as a response
    $preview = view('admin.admitcard._view', $data)->render();

    }
    return response()->json([
        'success' => true,
        'data' => $preview, // Return rendered HTML
    ], 200);
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
        $validatedData = $request->all();
    
        $admitcard = TemplateAdmitcards::find($id);
    
        if (!$admitcard) {
            return response()->json([
                'success' => false,
                'message' => 'Admitcard not found',
            ], 404); 
        }
   
        $admitcard->template = $validatedData['template'];
    $admitcard->heading = $validatedData['heading'] ?? null;
    $admitcard->title = $validatedData['title'] ?? null;
    $admitcard->left_logo = $validatedData['left_logo'] ?? null;
    $admitcard->right_logo = $validatedData['right_logo'] ?? null;
    $admitcard->exam_name = $validatedData['exam_name'] ?? null;
    $admitcard->school_name = $validatedData['school_name'] ?? null;
    $admitcard->exam_center = $validatedData['exam_center'] ?? null;
    $admitcard->sign = $validatedData['sign'] ?? null;
    $admitcard->background_img = $validatedData['background_img'] ?? null;
    $admitcard->is_name = ($validatedData['is_name'] === 'false' || !$validatedData['is_name']) ? 0 : 1;
    $admitcard->is_father_name = ($validatedData['is_father_name'] === 'false' || !$validatedData['is_father_name']) ? 0 : 1;
    $admitcard->is_mother_name = ($validatedData['is_mother_name'] === 'false' || !$validatedData['is_mother_name']) ? 0 : 1;
    $admitcard->is_dob = ($validatedData['is_dob'] === 'false' || !$validatedData['is_dob']) ? 0 : 1;
    $admitcard->is_admission_no = ($validatedData['is_admission_no'] === 'false' || !$validatedData['is_admission_no']) ? 0 : 1;
    $admitcard->is_roll_no = ($validatedData['is_roll_no'] === 'false' || !$validatedData['is_roll_no']) ? 0 : 1;
    $admitcard->is_address = ($validatedData['is_address'] === 'false' || !$validatedData['is_address']) ? 0 : 1;
    $admitcard->is_gender = ($validatedData['is_gender'] === 'false' || !$validatedData['is_gender']) ? 0 : 1;
    $admitcard->is_photo = ($validatedData['is_photo'] === 'false' || !$validatedData['is_photo']) ? 0 : 1;
    $admitcard->is_class = ($validatedData['is_class'] === 'false' || !$validatedData['is_class']) ? 0 : 1;
    $admitcard->is_section = ($validatedData['is_section'] === 'false' || !$validatedData['is_section']) ? 0 : 1;
    $admitcard->content_footer = $validatedData['content_footer'] ?? null;
    
        $file = $request->file('background_img');
    if ($file) {
        $imageName = $admitcard->staff_id . '_document_' . time();
        $imageSubfolder = "/Admitcard/" . $admitcard->staff_id; 
        $full_path = 0;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $admitcard->background_img = $imagePath;
    } else {
        $admitcard->background_img = ''; 
    }


        $admitcard->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Admitcard updated successfully',
            'admitcard' => $admitcard,
        ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $admitcard = TemplateAdmitcards::findOrFail($id);
            $admitcard->delete();
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => ' deletion failed: ' . $e->getMessage()], 500);
        }
    }


     public function generateMultiple(Request $request)
    {
        $studentData = $request->input('data');
        $studentArray = json_decode($studentData);
        $certificateId = $request->input('admitcard_id');
        $classId = $request->input('class_id');

        $results = [];
        $studentIds = [];
        $data = [];

        // Fetch school settings
        $data['sch_setting'] = DB::table('sch_settings')
            ->join('sessions', 'sessions.id', '=', 'sch_settings.session_id')
            ->join('languages', 'languages.id', '=', 'sch_settings.lang_id')
            ->select(
                'sch_settings.*',
                'sessions.session',
                'languages.language'
            )
            ->first();

        // Fetch admitcard details
        $data['admitcard'] = DB::table('admitcards')->where('id', $admitcardId)->first();

        foreach ($studentArray as $student) {
            $studentIds[] = $student->student_id;


            $existingadmitcard = DB::table('template_admitcards')
                ->where('student_id', $student->student_id)
                ->first();

            if (!$existingadmitcard) {
                // Generate a new TC number
                $maxTcNo = DB::table('template_admitcards')->max('tc_no');
                $newTcNo = $maxTcNo ? $maxTcNo + 1 : 1;

                // Insert the new TC admitcard
                DB::table('template_admitcards')->insert([
                    'student_id' => $student->student_id,
                    'tc_no' => $newTcNo,
                ]);
            }

            // Fetch updated TC admitcard
            $certData = DB::table('template_admitcards')
                ->where('student_id', $student->student_id)
                ->first();

            $results[] = $certData;
        }

        // Fetch student details
        $data['students'] = DB::table('students')
            ->whereIn('id', $studentIds)
            ->get();

        // Append TC number and full name to each student
        foreach ($data['students'] as $student) {
            $admitcard = collect($results)->firstWhere('student_id', $student->id);
            $student->tc_no = $admitcard->tc_no ?? null;

            // Assuming a custom method exists to generate the full name
            $student->name = $this->getFullName($student);
        }

        // Render the admitcard view
        $admitcards = view('admin.admitcard.createadmitcard', $data)->render();



        return response()->json([
            'success' => true,
            'data' => $admitcards, // Return rendered HTML
        ], 200);
    }
}