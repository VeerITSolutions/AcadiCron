<?php

namespace App\Http\Controllers;

use App\Models\SubjectTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $class_id    = $request->input('class_id');
        $section_id  =  $request->input('section_id');
        $subject_group_id  =  $request->input('subject_group_id');

        $days = getDayList();
        $days_record = [];


        foreach ($days as $day_key => $day_value) {
            /* subject_timetable */
            $days_record[$day_key] = SubjectTimetable::where('class_id', $class_id)
                                                    ->where('section_id', $section_id)
                                                    ->where('subject_group_id', $subject_group_id)
                                                    ->where('day', $day_key)
                                                    ->get();
        }


        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $days_record, // Only return the current page data

            'message' => $message,
        ], 200);

        /* $data['timetable'] = $days_record; */
        /* return view('your_view', compact('data')); */
    }

    public function getBySubjectGroupDayClassSection($group_id = null, $day_id = null, $class_id = null, $section_id = null)
{
    $query = DB::table('subject_timetable')
        ->select('subject_timetable.*')
        ->join('subject_group_subjects', 'subject_timetable.subject_group_subject_id', '=', 'subject_group_subjects.id')
        ->join('staff', 'subject_timetable.staff_id', '=', 'staff.id')
        ->where('staff.is_active', 1);

    // Apply group_id filter only if provided
    if ($group_id) {
        $query->where('subject_timetable.subject_group_id', $group_id);
    }

    // Apply day_id filter only if provided
    if ($day_id) {
        $query->where('subject_timetable.day', $day_id);
    }

    // Apply class_id filter only if provided
    if ($class_id) {
        $query->where('subject_timetable.class_id', $class_id);
    }

    // Apply section_id filter only if provided
    if ($section_id) {
        $query->where('subject_timetable.section_id', $section_id);
    }

    // Order by start time
    $query->orderBy('subject_timetable.start_time', 'asc');

    return $query->get();
}


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->all();



        // Create a new designation
        $subject_timetable = new SubjectTimetable();

        $subject_timetable->day = $validatedData['day'];
        $subject_timetable->class_id = $validatedData['class_id'];
        $subject_timetable->section_id = $validatedData['section_id'];
        $subject_timetable->subject_group_id = $validatedData['subject_group_id'];
        $subject_timetable->subject_group_subject_id = $validatedData['subject_group_subject_id'];
        $subject_timetable->staff_id = $validatedData['staff_id'];
        $subject_timetable->time_from = $validatedData['time_from'];
        $subject_timetable->time_to = $validatedData['time_to'];
        $subject_timetable->start_time = $validatedData['start_time'];
        $subject_timetable->end_time = $validatedData['end_time'];
        $subject_timetable->room_no = $validatedData['room_no'];
        $subject_timetable->session_id = $validatedData['session_id'];
        $subject_timetable->created_at = now(); // Use the current timestamp for created_at

        $subject_timetable->save();


        return response()->json([
            'success' => true,
            'message' => 'saved successfully',
            'subject_timetable' => $subject_timetable,
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
        // Attempt to find the category
        $subject_timetable = SubjectTimetable::find($id);



        // Validate the fields you need to validate
        $validatedData = $request->all();

        // Update the category with validated data
        $subject_timetable->update($validatedData);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Edit successful',
            'subject_timetable' => $subject_timetable,
        ], 200); // 200 OK status code
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $subject_timetable = SubjectTimetable::findOrFail($id);

            // Delete the category
            $subject_timetable->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
