<?php

namespace App\Http\Controllers;

use App\Models\FrontCmsMenus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontCmsMenusController extends Controller
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

        $data = FrontCmsMenus::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data->items(), 
            'totalCount' => $data->total(), 
            'rowsPerPage' => $data->lastPage(), 
            'currentPage' => $data->currentPage(),
            'message' => $message,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->all();
    
        $FrontCmsMenus = new FrontCmsMenus();
     
       
        $FrontCmsMenus->menu = $validatedData['menu'];
        $FrontCmsMenus->slug = $validatedData['slug'];
        $FrontCmsMenus->description = $validatedData['description'];
        $FrontCmsMenus->open_new_tab = $validatedData['open_new_tab'];
        $FrontCmsMenus->ext_url = $validatedData['ext_url'] ?? '';
        $FrontCmsMenus->ext_url_link = $validatedData['ext_url_link'] ?? '';
        $FrontCmsMenus->publish = $validatedData['publish'];
        $FrontCmsMenus->content_type = $validatedData['content_type'];
        $FrontCmsMenus->is_active = $validatedData['is_active'];
        $FrontCmsMenus->created_at = $validatedData['created_at'] ?? now();


        $FrontCmsMenus->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Item Category saved successfully',
            'FrontCmsMenus' => $FrontCmsMenus,
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

        $FrontCmsMenus = FrontCmsMenus::findOrFail($id);

        $FrontCmsMenus->menu = $validatedData['menu'];
        $FrontCmsMenus->slug = $validatedData['slug'];
        $FrontCmsMenus->description = $validatedData['description'];
        $FrontCmsMenus->open_new_tab = $validatedData['open_new_tab'];
        $FrontCmsMenus->ext_url = $validatedData['ext_url'] ?? '';
        $FrontCmsMenus->ext_url_link = $validatedData['ext_url_link'] ?? '';
        $FrontCmsMenus->publish = $validatedData['publish'];
        $FrontCmsMenus->content_type = $validatedData['content_type'];
        $FrontCmsMenus->is_active = $validatedData['is_active'];
        $FrontCmsMenus->created_at = $validatedData['created_at'] ?? now();

    
        $FrontCmsMenus->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'FrontCmsMenus' => $FrontCmsMenus,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $FrontCmsMenus = FrontCmsMenus::findOrFail($id);

            $FrontCmsMenus->delete();

            return response()->json(['success' => true, 'message' => 'Item Category  deleted successfully']);
        } catch (\Exception $e) {
        
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
