<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\structure;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }


    public function getStructures()
    {
        try{
            $structures = structure::get();
            $structures = $structures->map(function ($structures) {
                return [
                    'id' => $structures->id_structure, // Rename field
                    'nom' => $structures->nom,        // Include other fields as needed
                    // Add other fields you want to return
                ];
            });
            return response()->json($structures, 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e, 200);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'structure' => 'required|string|',

        ]);
        try {
            $structure = new Structure;
            $structure->nom = $validated['structure'];
            $structure->save();
            return response()->json(['message' => 'structure Inserted successfully!','data' => $structure,], 200); 

        }catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 300);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{

            // Validate the incoming request
            $validated = $request->validate([
                'nom' => 'required|string|',
            ]);

            $structure = Structure::find($id);

            if (!$structure) {
                return response()->json([
                    'message' => 'structure not found.',
                ], 404);
            }
            

            $structure->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'structure updated successfully.',
                'contract' => $structure,
            ],200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 300);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $structure = Structure::findOrFail($id);

        // Delete the contract
        $structure->delete();

        // Return a response, could be a success message or just a status code
        return response()->json([
            'message' => 'structure deleted successfully!'
        ]);
    }
}