<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\MultiClassStudents; 
use App\Models\Sections;
use App\Models\StudentSession;
use App\Models\Students;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MultiClassStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Form validation
    
        $validated = $request->all();
    
        $students = [];
        $message = '';
    
        if ($validated) {
            $class_id = $request->input('class_id');
            $section_id = $request->input('section_id');
    
            // Fetch students based on class and section
            $students = StudentSession::where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->get();
    
            $message = 'Students retrieved successfully.';
        } else {
            $message = 'Validation failed.';
        }
    
        // Return JSON response
        return response()->json([
            'success' => true,
            'data' => $students, // Return matching records
            'totalCount' => $students ? $students->count() : 0, // Count of matching records
            'message' => $message,
        ], 200);
    }
    
    
    public function saveMultiClass(Request $request)
{
    $student_id = '';
    $message = "";
    $duplicate_record = 0;
    
    $validated = $request->all();
    $total_rows = $request->input('row_count');
    
    if (!empty($total_rows)) {
        foreach ($total_rows as $row_count) {
            $request->validate([
                'class_id_' . $row_count => 'required|trim',
                'section_id_' . $row_count => 'required|trim',
            ]);
        }
    }

    $msg = [];
    if ($validated) {
        $rowcount = $request->input('row_count');
        $class_section_array = [];
        $duplicate_array = [];
        
        foreach ($rowcount as $value_rowcount) {
            $class_section_array[] = [
                'class_id' => $request->input('class_id_' . $value_rowcount),
                'session_id' => $this->setting_model->getCurrentSession(),
                'student_id' => $request->input('student_id'),
                'section_id' => $request->input('section_id_' . $value_rowcount),
            ];
            $duplicate_array[] = $request->input('class_id_' . $value_rowcount) . "-" . $request->input('section_id_' . $value_rowcount);
        }

        // Check for duplicate entries
        $duplicates = array_count_values($duplicate_array);
        foreach ($duplicates as $val => $count) {
            if ($count > 1) {
                $duplicate_record = 1;
                break;
            }
        }

        if ($duplicate_record) {
            $array = [
                'status' => 0,
                'error' => '',
                'message' => 'Duplicate entry',
            ];
        } else {
            // Store the data in the database
            $this->add($class_section_array, $request->input('student_id'));

            $array = [
                'status' => 1,
                'error' => '',
                'message' => 'Success message',
            ];
        }
    } else {
        // Collect validation errors
        foreach ($request->all() as $key => $value) {
            $msg[$key] = $this->getValidationErrorMessage($key);
        }

        $array = [
            'status' => 0,
            'error' => $msg,
            'message' => 'Something went wrong',
        ];
    }

    return response()->json($array);
}

// Helper method to get validation error messages
private function getValidationErrorMessage($field)
{
    return $this->validator->errors()->get($field)[0] ?? '';
}


    public function add($insert_array, $student_id)
    {
        $not_delarray = [];
        
        // Start transaction
        DB::beginTransaction();
    
        try {
            if (!empty($insert_array)) {
                foreach ($insert_array as $insert_array_value) {
                    // Check if record already exists in student_session table
                    $existing = StudentSession::where('session_id', $insert_array_value['session_id'])
                                              ->where('student_id', $insert_array_value['student_id'])
                                              ->where('class_id', $insert_array_value['class_id'])
                                              ->where('section_id', $insert_array_value['section_id'])
                                              ->first();
    
                    if ($existing) {
                        $not_delarray[] = $existing->id;
                    } else {
                        // Insert new record
                        $studentSession = new StudentSession($insert_array_value);
                        $studentSession->save();
                        $not_delarray[] = $studentSession->id;
                    }
                }
            }
    
            // Delete records that are not in the insert array
            if (!empty($not_delarray)) {
                StudentSession::where('session_id', $this->current_session)
                              ->where('student_id', $student_id)
                              ->whereNotIn('id', $not_delarray)
                              ->delete();
            }
    
            // Commit the transaction
            DB::commit();
    
            return true;
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            return false;
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
