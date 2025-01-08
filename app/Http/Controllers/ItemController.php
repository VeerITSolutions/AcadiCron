<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page'); 
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }

        
        if(isset($request->selectedItemCategoryId)){
            $data = Item::leftJoin('item_category', 'item.item_category_id', '=', 'item_category.id')
            ->where('item.item_category_id', $request->selectedItemCategoryId)
            ->orderBy('item.id', 'desc')
            ->paginate($perPage, ['item.*', 'item_category.item_category as item_category'], 'page', $page);
            $message = '';
            
        return response()->json([
            'success' => true,
            'data' => $data->items(), 
            'totalCount' => $data->total(), 
            'rowsPerPage' => $data->lastPage(), 
            'currentPage' => $data->currentPage(),
            'message' => $message,
        ], 200);

        }else{
            $data = Item::leftJoin('item_category', 'item.item_category_id', '=', 'item_category.id')
            ->orderBy('item.id', 'desc')
            ->paginate($perPage, ['item.*', 'item_category.item_category as item_category'], 'page', $page);
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

    }

    /**
     * Show the form for creating a new resource.
     */


     public function getItems(Request $request)
{
    $perPage = $request->input('perPage', 10); // Number of items per page
    $page = $request->input('page', 1); // Current page
    $id = $request->input('id'); // Optional item ID

    $query = DB::table('item')
        ->leftJoin('item_category', 'item.item_category_id', '=', 'item_category.id')
        ->leftJoin('item_store', 'item.item_store_id', '=', 'item_store.id')
        ->leftJoin('item_supplier', 'item.item_supplier_id', '=', 'item_supplier.id')
        ->leftJoin(DB::raw('(SELECT item_stock.item_id, SUM(quantity) as item_stock_quantity FROM item_stock GROUP BY item_stock.item_id) as item_stock'), 'item_stock.item_id', '=', 'item.id')
        ->leftJoin(DB::raw('(
            SELECT 
                m.item_id as issue_item_id, 
                IFNULL((SELECT SUM(quantity) FROM item_issue WHERE item_issue.item_id = m.item_id AND item_issue.is_returned = 1), 0) as issued,
                IFNULL((SELECT SUM(quantity) FROM item_issue WHERE item_issue.item_id = m.item_id AND item_issue.is_returned = 0), 0) as returned 
            FROM item_issue m 
            GROUP BY m.item_id
        ) as item_issues'), 'item_issues.issue_item_id', '=', 'item.id')
        ->select(
            'item.*',
            'item_category.item_category',
            'item_store.item_store',
            'item_store.code',
            'item_supplier.item_supplier',
            'item_supplier.phone',
            'item_supplier.email',
            'item_supplier.address',
            DB::raw('IFNULL(item_issues.issued, 0) as issued'),
            DB::raw('IFNULL(item_issues.returned, 0) as returned'),
            DB::raw('IFNULL(item_stock.item_stock_quantity, 0) as added_stock')
        );

    if ($id) {
        $query->where('item.id', $id);
    }

    $data = $query->orderBy('item.id', 'desc')->paginate($perPage, ['*'], 'page', $page);

    return response()->json([
        'success' => true,
        'data' => $data->items(),
        'totalCount' => $data->total(),
        'rowsPerPage' => $data->perPage(),
        'currentPage' => $data->currentPage(),
        'message' => '',
    ], 200);
}
    public function create(Request $request)
    {
        $validatedData = $request->all();
    
        $Item = new Item();
        $Item->item_category_id = $validatedData['item_category_id'];
        $Item->name = $validatedData['name'];
        $Item->unit = $validatedData['unit'];
        $Item->item_photo = $validatedData['item_photo'];
        $Item->description = $validatedData['description'];
        $Item->created_at = $validatedData['created_at']  ?? now();
        $Item->updated_at = $validatedData['updated_at'] ?? now();
        $Item->item_store_id = $validatedData['item_store_id'];
        $Item->item_supplier_id = $validatedData['item_supplier_id'];
        $Item->quantity = $validatedData['quantity'] ?? 0;
        // Add the date field here if it is required
        $Item->date = $validatedData['date'] ?? now();
    
        $Item->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Item saved successfully',
            'Item' => $Item,
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

        $Item = Item::findOrFail($id);
        $Item->item_category_id = $validatedData['item_category_id'];
        $Item->name = $validatedData['name'];
        $Item->unit = $validatedData['unit'];
        $Item->item_photo = $validatedData['item_photo'];
        $Item->description = $validatedData['description'];
        $Item->created_at = $validatedData['created_at'];
        $Item->updated_at = $validatedData['updated_at'];
        $Item->item_store_id = $validatedData['item_store_id'];
        $Item->item_supplier_id = $validatedData['item_supplier_id'];
        $Item->quantity = $validatedData['quantity'] ?? 0;
        
     
        $Item->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Item' => $Item,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Item = Item::findOrFail($id);

            $Item->delete();

            return response()->json(['success' => true, 'message' => 'Item Category  deleted successfully']);
        } catch (\Exception $e) {
        
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
