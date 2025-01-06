<?php

namespace App\Http\Controllers;

use App\Models\ItemSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemSupplierController extends Controller
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

        $data = ItemSupplier::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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
    
        $ItemSupplier = new ItemSupplier();
        $ItemSupplier->item_supplier = $validatedData['item_supplier'];
        $ItemSupplier->phone = $validatedData['phone'];
        $ItemSupplier->email = $validatedData['email'];
        $ItemSupplier->address = $validatedData['address'];
        $ItemSupplier->contact_person_name = $validatedData['contact_person_name'];
        $ItemSupplier->contact_person_phone = $validatedData['contact_person_phone'];
        $ItemSupplier->contact_person_email = $validatedData['contact_person_email'];
        $ItemSupplier->description = $validatedData['description'];

        $ItemSupplier->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Item Category saved successfully',
            'ItemSupplier' => $ItemSupplier,
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

        $ItemSupplier = ItemSupplier::findOrFail($id);

        $ItemSupplier->item_supplier = $validatedData['item_supplier'];
        $ItemSupplier->phone = $validatedData['phone'];
        $ItemSupplier->email = $validatedData['email'];
        $ItemSupplier->address = $validatedData['address'];
        $ItemSupplier->contact_person_name = $validatedData['contact_person_name'];
        $ItemSupplier->contact_person_phone = $validatedData['contact_person_phone'];
        $ItemSupplier->contact_person_email = $validatedData['contact_person_email'];
        $ItemSupplier->description = $validatedData['description'];

    
        $ItemSupplier->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'ItemSupplier' => $ItemSupplier,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $ItemSupplier = ItemSupplier::findOrFail($id);

            $ItemSupplier->delete();

            return response()->json(['success' => true, 'message' => 'Item Category  deleted successfully']);
        } catch (\Exception $e) {
        
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
