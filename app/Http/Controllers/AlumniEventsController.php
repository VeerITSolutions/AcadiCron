<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\AlumniEvents;
use App\Models\Sections;
use App\Models\Sessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadeSession;

class AlumniEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }

        $data = AlumniEvents::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
        foreach ($data as $key => $event) {
            if (!empty($event->class_id)) {
                $eventclasslist = Classes::find($event->class_id);
                $event->eventclass = $eventclasslist->class;
                $eventsectionlist = Sections::find($event->section);
                $event->eventsection = $eventsectionlist->section ?? "";
                $sessionlist = Sessions::find($event->session_id);
                $event->eventsession = $sessionlist->session_name ?? "";
            } else {
                $event->eventclass = '';
                $event->eventsection = '';
                $event->eventsession = '';
            }
        }

        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'totalCount' => $data->total(),
            'rowsPerPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'message' => $message
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->all();

        $AlumniEvents = new AlumniEvents();
        $AlumniEvents->title = $validatedData['title'];
        $AlumniEvents->event_for = $validatedData['event_for'] ?? "";
        $AlumniEvents->session_id = $validatedData['session_id'] ?? 1;
        $AlumniEvents->class_id = $validatedData['class_id'] ?? "";
        $AlumniEvents->section = $validatedData['section'] ?? "";
        $AlumniEvents->from_date = $validatedData['from_date'];
        $AlumniEvents->to_date = $validatedData['to_date'];
        $AlumniEvents->note = $validatedData['note'];
        $AlumniEvents->photo = $validatedData['photo'] ?? "";
        $AlumniEvents->is_active = $validatedData['is_active'] ? 1 : 0;
        $AlumniEvents->event_notification_message = $validatedData['event_notification_message'];
        $AlumniEvents->show_onwebsite = $validatedData['show_onwebsite'] ? 1 : 0;


        $AlumniEvents->save();

        return response()->json([
            'success' => true,
            'message' => 'Alumni Events saved successfully',
            'AlumniEvents' => $AlumniEvents,
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
        $validatedData = $request->all();

        $AlumniEvents = AlumniEvents::findOrFail($id);
        $AlumniEvents->title = $validatedData['title'];
        $AlumniEvents->event_for = $validatedData['event_for'] ?? "";
        $AlumniEvents->session_id = $validatedData['session_id'] ?? 1;
        $AlumniEvents->class_id = $validatedData['class_id'] ?? "";
        $AlumniEvents->section = $validatedData['section'] ?? "";
        $AlumniEvents->from_date = $validatedData['from_date'];
        $AlumniEvents->to_date = $validatedData['to_date'];
        $AlumniEvents->note = $validatedData['note'];
        $AlumniEvents->photo = $validatedData['photo'] ?? "";
        $AlumniEvents->is_active = $validatedData['is_active'] ? 1 : 0;
        $AlumniEvents->event_notification_message = $validatedData['event_notification_message'];
        $AlumniEvents->show_onwebsite = $validatedData['show_onwebsite'] ? 1 : 0;


        $AlumniEvents->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'AlumniEvents' => $AlumniEvents,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $AlumniEvents = AlumniEvents::findOrFail($id);

            $AlumniEvents->delete();

            return response()->json(['success' => true, 'message' => 'Alumni events deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Alumni events deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
