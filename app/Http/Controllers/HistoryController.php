<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Employer;
Use App\Models\Equipment;
Use App\Models\Hostory;




class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_employer' => 'required|integer',
            'id_equipement' => 'required|integer',
        ]);

        try {
            
            $employer = Employer::where('id_employer', $validated['id_employer'])->first();
            if (!$employer) {
                return response()->json(['message' => 'Employer not found!'], 200);
            }

            $equipement = Equipment::where('id_equipement', $validated['id_equipement'])->first();
            if (!$equipement) {
                return response()->json(['message' => 'Equipement not found!'], 200);
            }


            $currentDateTime = now('Africa/Algiers');
            
            $history = new Hostory;
            $history->type = 'affectation';
            $history->date = $currentDateTime;
            $history->id_equipement	 = $equipement->id_equipement; 
            $history->id_employer	 = $employer->id_employer; 


            $history->save();

            return response()->json(['message' => 'Employer Inserted successfully!','data' => $history,], 200); 

        }catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
