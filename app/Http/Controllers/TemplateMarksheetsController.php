<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateMarksheets;

class TemplateMarksheetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
    
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }
    
        $data = TemplateMarksheets::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    
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

    $existingMarksheet = TemplateMarksheets::where('template', $validatedData['template'])->first();

    if ($existingMarksheet) {
        return response()->json([
            'success' => false,
            'message' => 'Template already exists',
        ], 409); 
    }

    $marksheets = new TemplateMarksheets();

    $marksheets->template = $validatedData['template'];
    $marksheets->heading = $validatedData['heading'] ?? null;
    $marksheets->title = $validatedData['title'] ?? null;
    $marksheets->left_logo = $validatedData['left_logo'] ?? null;
    $marksheets->right_logo = $validatedData['right_logo'] ?? null;
    $marksheets->exam_name = $validatedData['exam_name'] ?? null;
    $marksheets->school_name = $validatedData['school_name'] ?? null;
    $marksheets->exam_center = $validatedData['exam_center'] ?? null;
    $marksheets->left_sign = $validatedData['left_sign'] ?? null;
    $marksheets->middle_sign = $validatedData['middle_sign'] ?? null;
    $marksheets->right_sign = $validatedData['right_sign'] ?? null;
    $marksheets->exam_session = $validatedData['exam_session'] ?? 1;
    $marksheets->is_name = $validatedData['is_name'] ?? 1;
    $marksheets->is_father_name = $validatedData['is_father_name'] ?? 1;
    $marksheets->is_mother_name = $validatedData['is_mother_name'] ?? 1;
    $marksheets->is_dob = $validatedData['is_dob'] ?? 1;
    $marksheets->is_admission_no = $validatedData['is_admission_no'] ?? 1;
    $marksheets->is_roll_no = $validatedData['is_roll_no'] ?? 1;
    $marksheets->is_photo = $validatedData['is_photo'] ?? 1;
    $marksheets->is_division = $validatedData['is_division'] ?? 1;
    $marksheets->is_customfield = $validatedData['is_customfield'] ?? 0;
    $marksheets->background_img = $validatedData['background_img'] ?? null;
    $marksheets->date = $validatedData['date'] ?? null;
    $marksheets->is_class = $validatedData['is_class'] ?? 0;
    $marksheets->is_teacher_remark = $validatedData['is_teacher_remark'] ?? 1;
    $marksheets->is_section = $validatedData['is_section'] ?? 0;
    $marksheets->content = $validatedData['content'] ?? null;
    $marksheets->content_footer = $validatedData['content_footer'] ?? null;

 
    $file = $request->file('background_img');
    if ($file) {
        $imageName = $marksheets->staff_id . '_document_' . time(); // Example name
        $imageSubfolder = "/marksheet/" . $marksheets->staff_id; // Example subfolder
        $full_path = 0;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $marksheets->background_img = $imagePath;
    } else {
        $marksheets->background_img = ''; // Provide a default value if no image is uploaded
    }

    $marksheets->save();

    return response()->json([
        'success' => true,
        'message' => 'Marksheet created successfully',
        'marksheets' => $marksheets,
    ], 201);
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
    
        $marksheets = TemplateMarksheets::find($id);
    
        if (!$marksheets) {
            return response()->json([
                'success' => false,
                'message' => 'Marksheet not found',
            ], 404); 
        }
   
        $marksheets->template = $validatedData['template'];
        $marksheets->heading = $validatedData['heading'];
        $marksheets->title = $validatedData['title'];
        $marksheets->left_logo = $validatedData['left_logo'];
        $marksheets->right_logo = $validatedData['right_logo'];
        $marksheets->exam_name = $validatedData['exam_name'];
        $marksheets->school_name = $validatedData['school_name'];
        $marksheets->exam_center = $validatedData['exam_center'];
        $marksheets->left_sign = $validatedData['left_sign'];
        $marksheets->middle_sign = $validatedData['middle_sign'];
        $marksheets->right_sign = $validatedData['right_sign'];
        $marksheets->exam_session = $validatedData['exam_session'];
        $marksheets->is_name = $validatedData['is_name'];
        $marksheets->is_father_name = $validatedData['is_father_name'];
        $marksheets->is_mother_name = $validatedData['is_mother_name'];
        $marksheets->is_dob = $validatedData['is_dob'];
        $marksheets->is_admission_no = $validatedData['is_admission_no'];
        $marksheets->is_roll_no = $validatedData['is_roll_no'];
        $marksheets->is_photo = $validatedData['is_photo'];
        $marksheets->is_division = $validatedData['is_division'];
        $marksheets->is_customfield = $validatedData['is_customfield'] ?? 0;
        $marksheets->background_img = $validatedData['background_img'];
        $marksheets->date = $validatedData['date'];
        $marksheets->is_class = $validatedData['is_class'];
        $marksheets->is_teacher_remark = $validatedData['is_teacher_remark'];
        $marksheets->is_section = $validatedData['is_section'];
        $marksheets->content = $validatedData['content'];
        $marksheets->content_footer = $validatedData['content_footer'];
    
        $file = $request->file('background_img');
    if ($file) {
        $imageName = $marksheets->staff_id . '_document_' . time();
        $imageSubfolder = "/marksheet/" . $marksheets->staff_id; 
        $full_path = 0;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $marksheets->background_img = $imagePath;
    } else {
        $marksheets->background_img = ''; 
    }


        $marksheets->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Marksheet updated successfully',
            'marksheets' => $marksheets,
        ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $marksheets = TemplateMarksheets::findOrFail($id);
            $marksheets->delete();
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => ' deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
