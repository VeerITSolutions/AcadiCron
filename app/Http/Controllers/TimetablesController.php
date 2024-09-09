<?php

namespace App\Http\Controllers;

use App\Models\SubjectTimetable;
use Illuminate\Http\Request;

class TimetablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $class_id    = 2 ;//$request->input('class_id');
        $section_id  =  1; //$request->input('section_id');

        $days = getDayList();
        $days_record = [];


        foreach ($days as $day_key => $day_value) {
            /* subject_timetable */
            $days_record[$day_key] = SubjectTimetable::where('class_id', $class_id)
                                                    ->where('section_id', $section_id)
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
