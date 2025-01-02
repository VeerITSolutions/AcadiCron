<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeHead;
use Illuminate\Support\Facades\Session;

class IncomeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        Session::put('top_menu', 'Income');
        Session::put('sub_menu', 'incomehead/index');

        $page = $request->input('page', 1); 
        $perPage = $request->input('perPage', 10); 

        $page = (int) $page;
        $perPage = (int) $perPage;
   
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }

        $incomeHeads = IncomeHead::orderBy('id', 'desc')->paginate($perPage);
    
        return response()->json([
            'title' => 'Income Head List',
            'incomelist' => $incomeHeads->items(), 
            'totalCount' => $incomeHeads->total(), 
            'currentPage' => $incomeHeads->currentPage(),
            'rowsPerPage' => $perPage,
        ]);
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
