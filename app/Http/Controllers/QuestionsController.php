<?php

namespace App\Http\Controllers;


use App\Models\Questions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsControlller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page'); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Paginate the students data

            $data = Questions::orderBy('id', 'desc')->get();
            $message = '';

            // Return the paginated data with total count and pagination details
            return response()->json([
                'success' => true,
                'data' => $data, // Only return the current page data
            ], 200);
        
        // Prepare the response message
    }
    



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validatedData = $request->all();

          // Create a new Question
          $question = new question();
          $question->subject_id = $validatedData['subject_id'];
          $question->question_type = $validatedData['question_type'];
          $question->level = $validatedData['level'];
          $question->class_id = $validatedData['class_id'];
          $question->section_id = $validatedData['section_id'];
  

       $getQuestion =  $validatedData['Question'];
       $getQuestionData =  $validatedData['data'];
      
       foreach($getQuestionData as $getValue){
        $getRoute_id = $getValue;
       }

       
    
       foreach($getQuestion as $question){  
        $questiontype = new questiontype();
     
       
        $questiontype->question_id = $getquestion_id;

       
        $question_Type->question_type = $question;

        $question_Type->save();
        }
       

        return response()->json([
            'success' => true,
            'message' => 'Question saved successfully',
            'Questions' => $questiontype,
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
        

       $getQuestion =  $validatedData['Question'];
       $getQuestionData =  $validatedData['data'];
      
       foreach($getQuestionData as $getValue){
        $getRoute_id = $getValue;
       }

       
    
       foreach($getQuestion as $question){  
        $questiontype = new questiontype();
     
       
        $questiontype->question_id = $getquestion_id;

       
        $question_Type->question_type = $question;

        $question_Type->save();
        }
       

        return response()->json([
            'success' => true,
            'message' => 'Question saved successfully',
            'Questions' => $questiontype,
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
     
            $question = Question::findOrFail($id);

            $question->delete();

            return response()->json(['success' => true, 'message' => 'question  deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'question deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
