<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\MultiClassStudents;
use App\Models\Sections;
use App\Models\StudentSession;
use App\Models\Students;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MultiClassStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Form validation

        $validated = $request->all();
        $class_id = $request->input('class_id');
        $section_id = $request->input('section_id');
        $currentSessionId = $request->input('getselectedSessionId');
        $students = [];
        $message = '';
        $student_object = new Students();
        $students = $student_object->searchByClassSectionWithSession($class_id, $section_id , $currentSessionId);

        if ($validated) {

            if (!empty($students)) {
                foreach ($students as $studentKey => $studentValue) {
                    $studentSessions = DB::table('student_session')
                        ->where('student_id', $studentValue->id)
                        ->where('session_id', $currentSessionId)
                        ->orderBy('id')
                        ->get();

                    // Convert to array if $students is a collection
                    if (is_object($students)) {
                        $students = $students->toArray();
                    }

                    // Add the retrieved sessions to the student's data
                    $students[$studentKey]->student_sessions = $studentSessions;
                }
            }



            $message = 'Students retrieved successfully.';
        } else {
            $message = 'Validation failed.';
        }

        // Return JSON response
        return response()->json([
            'success' => true,
            'data' => $students, // Return matching records
            'totalCount' => $students ? count($students) : 0, // Count of matching records
            'message' => $message,
        ], 200);
    }


    public function saveMultiClass(Request $request)
    {
        $duplicate_record = 0;
    
        // Validate incoming request
        $validated = $request->all();
        $total_rows = $request->input('row_count');
    
        // Validate row inputs
        if (!empty($total_rows) && is_array($total_rows)) {
            foreach ($total_rows as $row_count) {
                $request->validate([
                    'class_id_' . $row_count => 'required|string|trim',
                    'section_id_' . $row_count => 'required|string|trim',
                ]);
            }
        } else {
            // Handle invalid or missing row_count input
            return response()->json([
                'status' => 0,
                'error' => 'Invalid input',
                'message' => 'row_count must be an array and cannot be null.',
            ]);
        }
    
        $class_section_array = [];
        $duplicate_array = [];
    
        // Prepare data and check for duplicates
        foreach ($total_rows as $value_rowcount) {
            $class_id = $request->input('class_id_' . $value_rowcount);
            $section_id = $request->input('section_id_' . $value_rowcount);
    
            $class_section_array[] = [
                'class_id' => $class_id,
                'session_id' => $this->setting_model->getCurrentSession(),
                'student_id' => $request->input('student_id'),
                'section_id' => $section_id,
            ];
    
            $duplicate_array[] = $class_id . '-' . $section_id;
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
            return response()->json([
                'status' => 0,
                'error' => '',
                'message' => 'Duplicate entry detected. Please check your input.',
            ]);
        }
    
        // Store data in the database
        $this->add($class_section_array, $request->input('student_id'));
    
        return response()->json([
            'status' => 1,
            'error' => '',
            'message' => 'Data successfully saved.',
        ]);
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
