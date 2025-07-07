<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\FrontCmsMediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontMediaGalleryController extends Controller
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
            $data = DB::table('front_cms_media_gallery')->orderBy('id', 'desc')->get();

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
        $totalCount = DB::table('events')->count();

        // Get paginated data
        $data = DB::table('front_cms_media_gallery')
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
        $validatedData = $request->all();

        $media_type = $validatedData['type'];
        if ($media_type == 'image') {
            $validatedData['file'] = $request->file('file')->store('images', 'public');


            $cmsMediaGallery = FrontCmsMediaGallery::create([
                'image' => $validatedData['file'],
                'thumb_path' => $validatedData['thumb_path'] ?? '',
                'dir_path' => $validatedData['dir_path'] ?? '',
                'img_name' => $validatedData['img_name'] ?? '',
                'thumb_name' => $validatedData['thumb_name'] ?? '',
                'file_type' => $validatedData['file_type'] ?? '',
                'file_size' => $validatedData['file_size'] ?? '',
                'vid_url' => $validatedData['vid_url'] ?? '',
                'vid_title' => $validatedData['vid_title'] ?? '',
            ]);
        } elseif ($media_type == 'video') {
            $cmsMediaGallery = new FrontCmsMediaGallery();
            $cmsMediaGallery->image = $validatedData['file'];






            $cmsMediaGallery->save();
        }


        return response()->json([
            'success' => true,
            'message' => 'Media Gallery saved successfully',
            'Events' => $cmsMediaGallery,
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

        $cmsMediaGallery = FrontCmsMediaGallery::findOrFail($id);

        $cmsMediaGallery->image = $validatedData['image'];
        $cmsMediaGallery->thumb_path = $validatedData['thumb_path'];
        $cmsMediaGallery->dir_path = $validatedData['dir_path'];
        $cmsMediaGallery->img_name = $validatedData['img_name'];
        $cmsMediaGallery->thumb_name = $validatedData['thumb_name'];
        $cmsMediaGallery->created_at = now();
        $cmsMediaGallery->file_type = $validatedData['file_type'];
        $cmsMediaGallery->file_size = $validatedData['file_size'];
        $cmsMediaGallery->vid_url = $validatedData['vid_url'];
        $cmsMediaGallery->vid_title = $validatedData['vid_title'];

        $cmsMediaGallery->update();

        return response()->json([

            'success' => true,
            'message' => 'Media Gallery successfully',
            'Events' => $cmsMediaGallery,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Events = FrontCmsMediaGallery::findOrFail($id);

            $Events->delete();

            return response()->json(['success' => true, 'message' => 'Events Category  deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
