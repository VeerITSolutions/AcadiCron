<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectGroups; // Adjust the namespace as necessary
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;




class SubjectGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Initialize pagination variables
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);
    $getselectedSessionId = (int) $request->input('getselectedSessionId');

    $section_id = $request->input('section_id');
    $class_id = $request->input('class_id');
    if($section_id && $class_id){
        $query = SubjectGroups::with([
            'subjects',
            'session',
            'classSections.classSection.class',
            'classSections.classSection.section',
        ])->where('subject_groups.session_id', $getselectedSessionId);

        // Ensure $section_id is an array
        if (!is_array($section_id)) {
            $section_id = [$section_id];
        }

        // Applying the filter for classSections.classSection
        $query->whereHas('classSections.classSection', function ($q) use ($class_id, $section_id) {
            $q->where('class_id', $class_id)
              ->whereIn('section_id', $section_id);
        });

        // Adding order by clause
        $query->orderBy('id', 'desc');

        // Fetching the filtered and sorted data
        $data = $query->get();

        // Return paginated data with pagination details
        return response()->json([
            'success' => true,
            'data' => $data, // Current page data
        ], 200);
    }

    $query = SubjectGroups::with([
        'subjects',
        'session',
        'classSections.classSection.class',
    'classSections.classSection.section',
    ])->orderBy('id', 'desc');

/* 'classSections.classSection.class',
    'classSections.classSection.section',
    */


    // Apply pagination
    $paginatedData = $query->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'total' => $paginatedData->total(),
    ], 200);
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
    $data = $request->data;
    $subject_group = $request->subject_group;
    $section_group = $request->section_group;
    $session_id = $request->session_id;

    if (empty($data) || !is_array($data)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid or missing data for updating subject group.',
        ], 400);
    }

    DB::table('subject_groups')->where('id', $id)->update($data);

    $subject_group_subject_array = array_map(function ($subject_id) use ($id, $session_id) {
        return [
            'subject_group_id' => $id,
            'subject_id' => $subject_id,
            'session_id' => $session_id,
        ];
    }, $subject_group);

    DB::table('subject_group_subjects')->where('subject_group_id', $id)->delete();
    DB::table('subject_group_subjects')->insert($subject_group_subject_array);

    $section_group_array = array_map(function ($class_section_id) use ($id, $session_id) {
        return [
            'subject_group_id' => $id,
            'class_section_id' => $class_section_id,
            'session_id' => $session_id,
        ];
    }, $section_group);

    DB::table('subject_group_class_sections')->where('subject_group_id', $id)->delete();
    DB::table('subject_group_class_sections')->insert($section_group_array);

    return response()->json([
        'success' => true,
        'message' => 'Subject group updated successfully.',
    ], 200);
}

    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the category by ID
            $category = SubjectGroups::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => ' deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the  was not found)
            return response()->json(['success' => false, 'message' => ' deletion failed: ' . $e->getMessage()], 500);
        }
    }

    public function add(Request $request)
    {

        $data = $request->data;
        $subject_group = $request->subject_group;
        $section_group = $request->section_group;
        $session_id = $request->session_id;
        if (isset($data['id'])) {
            // Update subject group
            DB::table('subject_groups')->where('id', $data['id'])->update($data);
            $subject_group_id = $data['id'];
        } else {
            // Insert new subject group
            $subject_group_id = DB::table('subject_groups')->insertGetId($data);
        }

        // Prepare subject group subjects data
        $subject_group_subject_array = array_map(function ($subject_id) use ($subject_group_id, $session_id) {
            return [
                'subject_group_id' => $subject_group_id,
                'subject_id' => $subject_id,
                'session_id' => $session_id,
            ];
        }, $subject_group);

        // Batch insert into subject_group_subjects
        DB::table('subject_group_subjects')->insert($subject_group_subject_array);

        // Prepare subject group class sections data
        $section_group_array = array_map(function ($class_section_id) use ($subject_group_id, $session_id) {
            return [
                'subject_group_id' => $subject_group_id,
                'class_section_id' => $class_section_id,
                'session_id' => $session_id,
            ];
        }, $section_group);

        // Batch insert into subject_group_class_sections
        DB::table('subject_group_class_sections')->insert($section_group_array);

        return response()->json([
            'success' => true,
            'data' => '', // Current page data

        ], 200);
    }
}
