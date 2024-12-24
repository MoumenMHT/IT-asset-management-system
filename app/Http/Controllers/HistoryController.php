<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Employer;
Use App\Models\Equipment;
Use App\Models\Hostory;
use Carbon\Carbon;




class HistoryController extends Controller
{
   


    public function getHistory()
    {
        try {
            

            $history = Hostory::with('employer','equipement')->get();

            // Format the response
            $formattedhistory = $history->map(function ($history) {
                return [
                    'id' => $history->id_history,
                    'type' => $history->type,
                    'created_at' => Carbon::parse($history->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($history->updated_at)->format('Y-m-d H:i:s'),
                    'employer' => $history->employer,
                    'equipement' => $history->equipement,
                ];
            });
       
            if ($formattedhistory) {
                return response()->json( $formattedhistory , 200); // Return history with a success message
            } else {
                return response()->json(['status' => 'error', 'message' => 'No history found'], 200); // Return a not found response
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 200);
        }
    }



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
        try {
            // Validate input data
            $validated = $request->validate([
                // Validate employer object
                'employer' => 'required|array',
                'employer.id_employer' => 'required|integer',
    
                // Validate equipment object
                'equipement' => 'required|array',
                'equipement.id_equipement' => 'required|integer',
    
                // Validate type field
                'type' => '',
            ]);
    
            // Find employer by id
            $employer = Employer::where('id_employer', $validated['employer']['id_employer'])->first();
            if (!$employer) {
                return response()->json(['message' => 'Employer not found!'], 200);
            }
    
            // Initialize history object
            $history = new Hostory;
    
            // Check if type is provided and handle accordingly
            if (!empty($validated['type'])) {
                $history->type = $validated['type'];
    
                // Find equipment
                $equipement = Equipment::where('id_equipement', $validated['equipement']['id_equipement'])->first();
                if ($equipement) {
                    $history->id_equipement = $equipement->id_equipement;
                }
    
            } else {
                // Find available equipment
                $equipement = Equipment::where('id_equipement', $validated['equipement']['id_equipement'])
                                       ->where('status', 'disponible')
                                       ->first();
                
                if (!$equipement) {
                    return response()->json(['message' => 'Equipment not found or not available'], 200);
                }
    
                $history->type = 'affectation';
                $history->id_equipement = $equipement->id_equipement;
    
                // Update equipment status to "indisponible"
                $equipement->status = "indisponible";
                $equipement->update();
            }
    
            // Set the employer id for the history
            $history->id_employer = $employer->id_employer;
    
            // Save history object
            $history->save();
    
            // Return success response with history ID
            return response()->json(['message' => 'Employer inserted successfully!', 'id' => $history->id_history], 200);
    
        } catch (\Exception $e) {
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
        // Validate the incoming request
        $validated = $request->validate([
            'code' => 'required|string|',
            'equipement' => 'required|string|',
            'type' => 'required|string|',
        ]);

        try{

            
            $history = Hostory::find($id);

            if (!$history) {
                return response()->json([
                    'message' => 'history not found.',
                ], 200);
            }
            $equipement = Equipment::where('num_serie', $validated['equipement'])->first();
            if (!$equipement) {
                return response()->json(['message' => 'Eauipement not found!'], 200);
            }
            

            $history->id_equipement	 = $equipement->id_equipement;


            $employer = Employer::where('code', $validated['code'])->first();
            if (!$employer) {
                return response()->json(['message' => 'Employer not found!'], 200);
            }
            

            if($validated['type'] === 'desaffectation') {
                $equipement->status = 'disponible';
                $equipement->update();
            }

            $history->id_employer	 = $employer->id_employer;

            $history->type = $validated['type'];


            // Update the history
            $history->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'history updated successfully.',
                'history' => $history,
            ],200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 200);
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
        //
    }
}
