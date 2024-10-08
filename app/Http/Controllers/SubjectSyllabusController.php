<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectSyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get classId and sectionId from request parameters
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');
        $currentSession = "2023-2024"; // Assuming current_session is defined in the class.
    
        $subjects = DB::table('class_sections')
            ->join('subject_group_class_sections', 'subject_group_class_sections.class_section_id', '=', 'class_sections.id')
            ->join('subject_group_subjects', 'subject_group_subjects.subject_group_id', '=', 'subject_group_class_sections.subject_group_id')
            ->join('subjects', 'subject_group_subjects.subject_id', '=', 'subjects.id')
            ->select(
                'subject_group_subjects.id as subject_group_subjects_id',
                'subject_group_class_sections.id as subject_group_class_sections_id',
                'subjects.name',
                'subjects.code',
                'subjects.id as subject_id'
            )
            ->where('subject_group_class_sections.session_id', $currentSession)
            ->where('class_sections.class_id', $classId)
            ->where('class_sections.section_id', $sectionId)
            ->get();
    
        return response()->json($subjects); // Return the subjects as a JSON response
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
