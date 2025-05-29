<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $computer = Computer::all();
        return response()->json($computer, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string'
        ]);

        Computer::create($validatedData);
        return response()->json(['response' => 'success'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $computer = Computer::find($id);

        if($computer){
            return response()->json($computer);
        } 

        return response()->json(['response'=>'No records found!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $computer = Computer::find($id);

        if($computer){

            $validatedData = $request->validate([
                'brand' => 'required|string',
                'model' => 'required|string'
            ]);
            
            $computer->update($validatedData);

            return response()->json(['response'=>'success']);
        } 

        return response()->json(['response'=>'No records found!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $computer = Computer::find($id);

        if($computer){
            $computer->delete();
            return response()->json(['response' => 'success']);
        } 

        return response()->json(['response'=>'No records found!']);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        if (empty($searchTerm)) {
            return response()->json(['error' => 'Search term is required'], 400);
        }

        $computers = Computer::where('brand', 'like', '%' . $searchTerm . '%')->get();

        if ($computers->isNotEmpty()) {
            return response()->json($computers);
        }

        return response()->json(['response' => 'No records found!'], 404);
    }


}