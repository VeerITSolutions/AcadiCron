<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\FrontCmsMediaGallery;
use App\Models\FrontCmsPrograms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class FrontEventsController extends Controller
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

        $message = 'Events retrieved successfully';

        if (!$request->has('page')) {
            $data = DB::table('front_cms_programs')->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $data,
                'totalCount' => $data->count(),
                'rowsPerPage' => 1,
                'currentPage' => 1,
                'message' => $message,
            ], 200);
        }

        // Get total count
        $totalCount = DB::table('front_cms_programs')->count();

        // Get paginated data
        $data = DB::table('front_cms_programs')
            ->orderBy('id', 'desc')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'totalCount' => $totalCount,
            'rowsPerPage' => $perPage,
            'currentPage' => $page,
            'message' => $message,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $Events = new FrontCmsPrograms();
        $Events->title = $validatedData['title'];
        $Events->event_start = $validatedData['start_date'];
        $Events->event_end = $validatedData['end_date'];
        $Events->event_venue = $validatedData['venue'] ?? '';
        $Events->sidebar = '1';
        $Events->publish_date = now();
        $Events->publish = '0';
        $Events->is_active = 'no';
        $Events->meta_title = $validatedData['meta_title'] ?? '';
        $Events->meta_description = $validatedData['meta_description'] ?? '';
        $Events->meta_keyword = $validatedData['meta_keywords'] ?? '';

        // Upload the image using your helper
        if ($request->hasFile('feature_image')) {
            $file = $request->file('feature_image');
            $imageName = 'media_gallery_' . time();
            $imageSubfolder = 'gallery/media/';
            $file_path = 1; // Customize this logic as needed

            $storedPath = uploadImage($file, $imageName, $imageSubfolder, $file_path); // your helper
            $filename = basename($storedPath);

            // Save to media gallery table
            $media = new FrontCmsMediaGallery();
            $media->image = $filename;
            $media->img_name = $filename;
            $media->file_type = $file->getClientMimeType();
            $media->file_size = $file->getSize();
            $media->thumb_name = $filename;
            $media->thumb_path = $imageSubfolder . '/'; // optional, adjust if needed
            $media->dir_path = $imageSubfolder . '/';
            $media->vid_url = '';
            $media->created_at = now();
            $media->save();

            // Store image reference in event table
            $Events->feature_image = $filename;
        }

        $Events->save();

        return response()->json([
            'success' => true,
            'message' => 'Event saved successfully',
            'Events' => $Events,
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

        $Events = FrontCmsPrograms::findOrFail($id);
        $Events->title = $validatedData['title'];
        $Events->description = $validatedData['meta_description'];
        $Events->meta_title = $validatedData['meta_title'];
        $Events->meta_keyword = $validatedData['meta_keywords'];
        $Events->event_start = $validatedData['event_type'];
        $Events->event_end = $validatedData['event_color'];
        $Events->event_venue = $validatedData['venue'];
        $Events->feature_image = $validatedData['role_id'];
        $Events->sidebar = $validatedData['is_active'];
        $Events->type = $validatedData['is_active'];
        $Events->meta_description = $validatedData['meta_description'];


        $Events->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Events' => $Events,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Events = FrontCmsPrograms::findOrFail($id);

            $Events->delete();

            return response()->json(['success' => true, 'message' => 'Events Category  deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
