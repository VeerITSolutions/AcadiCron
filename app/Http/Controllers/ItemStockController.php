<?php

namespace App\Http\Controllers;

use App\Models\ItemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemStockController extends Controller
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


        $data = ItemStock::leftJoin('item', 'item.id', '=', 'item_stock.item_id')
        ->leftJoin('item_category', 'item.item_category_id', '=', 'item_category.id')
        ->leftJoin('item_supplier', 'item_stock.supplier_id', '=', 'item_supplier.id')
        ->leftJoin('item_store', 'item_store.id', '=', 'item_stock.store_id')
        ->select([
            'item_stock.*',
            'item.name as item_name',
            'item.item_category_id as item_category_id',
            'item.description as des',
            'item_category.item_category',
            'item_supplier.item_supplier as supplier_name',
            'item_store.item_store as store_name'
        ])
        ->orderBy('item_stock.id', 'desc')->get();


        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->all();

        $ItemStock = new ItemStock();
        $ItemStock->item_id = $validatedData['item_id'];
        $ItemStock->supplier_id = $validatedData['supplier_id'];
        $ItemStock->symbol = $validatedData['symbol'] ?? "+";
        $ItemStock->store_id = $validatedData['store_id'];
        $ItemStock->quantity = $validatedData['quantity'];
        $ItemStock->purchase_price = $validatedData['purchase_price'];
        $ItemStock->date = $validatedData['date'];
        $ItemStock->attachment = $validatedData['attachment'];
        $ItemStock->description = $validatedData['description'];
        $ItemStock->is_active = $validatedData['is_active'];

     // Handle file upload
     if ($request->hasFile('documents')) {
        $file = $request->file('documents');
        $imageName = 'inventory_' . time() . '.' . $file->getClientOriginalExtension();
        $imageSubfolder = 'inventory_items';
        $full_path = 1;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $ItemStock->documents = $imagePath;
    }

        $ItemStock->save();

        return response()->json([
            'success' => true,
            'message' => 'Item Category saved successfully',
            'ItemStock' => $ItemStock,
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

        $ItemStock = ItemStock::findOrFail($id);

        $ItemStock->item_id = $validatedData['item_id'];
        $ItemStock->supplier_id = $validatedData['supplier_id'];
        $ItemStock->symbol = $validatedData['symbol'] ?? "+";
        $ItemStock->store_id = $validatedData['store_id'];
        $ItemStock->quantity = $validatedData['quantity'];
        $ItemStock->purchase_price = $validatedData['purchase_price'];
        $ItemStock->date = $validatedData['date'];
        $ItemStock->attachment = $validatedData['attachment'];
        $ItemStock->description = $validatedData['description'];
        $ItemStock->is_active = $validatedData['is_active'];

        // Handle file upload
        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $imageName = 'inventory_' . time() . '.' . $file->getClientOriginalExtension();
            $imageSubfolder = 'inventory_items';
            $full_path = 1;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $ItemStock->documents = $imagePath;
        }


        $ItemStock->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'ItemStock' => $ItemStock,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $ItemStock = ItemStock::findOrFail($id);

            $ItemStock->delete();

            return response()->json(['success' => true, 'message' => 'Item Category  deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
