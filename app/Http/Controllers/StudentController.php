<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        return response()->json($student);
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
        $student = $request->validate([
            'name' =>'required|string',
            'address' => 'required|string'
        ]);

        Student::create([
            'name' => $student['name'],
            'address' =>$student['address'] 
        ]);

        return response()->json(['response' => 'success'], 200);
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
        
        $student = Student::find($id);

        if($student){

            $student->update([
                'name' => $request['name'],
                'address' => $request['address']
            ]);

            return response()->json(['response' => 'success'], 200);
        }

        return response()->json(['response' => 'error'], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['response' => $id]);

    }
}