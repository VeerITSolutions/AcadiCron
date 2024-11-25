<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

        public function searchStudentExams(Request $request, $is_active = false, $is_publish = false)
    {

        $student_session_id  = $request->id;

        $query = DB::table('exam_group_class_batch_exam_students')
            ->join('exam_group_class_batch_exams', 'exam_group_class_batch_exams.id', '=', 'exam_group_class_batch_exam_students.exam_group_class_batch_exam_id')
            ->join('exam_groups', 'exam_groups.id', '=', 'exam_group_class_batch_exams.exam_group_id')
            ->select(
                'exam_group_class_batch_exam_students.*',
                'exam_group_class_batch_exams.exam_group_id',
                'exam_group_class_batch_exams.exam',
                'exam_group_class_batch_exams.date_from',
                'exam_group_class_batch_exams.date_to',
                'exam_group_class_batch_exams.description',
                'exam_groups.name',
                'exam_groups.exam_type'
            )
            ->where('exam_group_class_batch_exam_students.student_session_id', $student_session_id);

        if ($is_active) {
            $query->where('exam_group_class_batch_exams.is_active', 1);
        }

        if ($is_publish) {
            $query->where('exam_group_class_batch_exams.is_publish', 1);
        }

        $student_exams = $query->orderBy('exam_group_class_batch_exam_students.id', 'asc')->get();

        if ($student_exams->isNotEmpty()) {
            foreach ($student_exams as $student_exam) {
                $student_exam->exam_result = $this->getStudentExamResults(
                    $student_exam->exam_group_class_batch_exam_id,
                    $student_exam->exam_group_id,
                    $student_exam->id,
                    $student_exam->student_id
                );
            }
        }



        return response()->json([
            'status' => 200,
            'message' => 'Student Exam Fetched',
            'data' => $student_exams,
        ], 200); // 201 Created status code
    }

/**
 * Example placeholder for `getStudentExamResults`.
 * Replace this with actual logic from the `examresult_model`.
 */
        private function getStudentExamResults($exam_group_class_batch_exam_id, $exam_group_id, $student_exam_id, $student_id)
        {
            // Fetch student exam results based on your logic
            return DB::table('exam_results')
                ->where('exam_group_class_batch_exam_id', $exam_group_class_batch_exam_id)
                ->where('exam_group_id', $exam_group_id)
                ->where('student_exam_id', $student_exam_id)
                ->where('student_id', $student_id)
                ->get();
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
