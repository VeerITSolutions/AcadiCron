<?php

namespace App\Http\Controllers;

use App\Models\ItemStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemStoreController extends Controller
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

        $data = ItemStore::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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
    
        $ItemStore = new ItemStore();
        $ItemStore->item_store = $validatedData['item_store'];
        $ItemStore->code = $validatedData['code'];
        $ItemStore->description = $validatedData['description'];

        $ItemStore->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Item Category saved successfully',
            'ItemStore' => $ItemStore,
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

        $ItemStore = ItemStore::findOrFail($id);

        $ItemStore->item_store = $validatedData['item_store'];
        $ItemStore->code = $validatedData['code'];
        $ItemStore->description = $validatedData['description'];

    
        $ItemStore->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'ItemStore' => $ItemStore,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $ItemStore = ItemStore::findOrFail($id);

            $ItemStore->delete();

            return response()->json(['success' => true, 'message' => 'Item Category  deleted successfully']);
        } catch (\Exception $e) {
        
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
