<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Equipment;


class EquipmentController extends Controller
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


    public function getEquipments()
    {
        
        try {
            $equipments = Equipment::with('contract')->get();
            if(!$equipments){
                return response()->json( 'eroor' , 200); // Return contracts with a success message

            }
            // Format the response
            $formattedEquipment = $equipments->map(function ($equipments) {
                return [
                    'id' => $equipments->id_equipement,
                    'num_serie' => $equipments->num_serie,
                    'Type' => $equipments->Type,
                    'marque' => $equipments->marque,
                    'etat' => $equipments->etat,
                    'status' => $equipments->status,
                    'date_amortissement' => $equipments->date_amortissement,
                    'contract' => $equipments->contract->ref ?? null, 
                ];
            });
       
            if ($formattedEquipment->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'No equipments found'], 404);
            }
            if ($formattedEquipment) {
                return response()->json( $formattedEquipment , 200); // Return contracts with a success message
            } else {
                return response()->json(['status' => 'error', 'message' => 'No contracts found'], 404); // Return a not found response
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 200);
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
        
        try {
            $validated = $request->validate([
                'num_serie' => 'required|string|',
                'contract' => 'required|string|',
                'Type' => 'required|string|',
                'marque' => 'required|string|',
                'etat'=> 'required|string|',
                'date_amortissement'=> 'required|date',
            ]);
            
            $contract = Contract::where('ref', $validated['contract'])->first();
            if (!$contract) {
                return response()->json(['message' => 'contract not found!'], 200);
            }
            $equipment = new Equipment();
            $equipment->id_contract	 = $contract->id_contract; 
            $equipment->num_serie = $validated['num_serie'];
            $equipment->Type = $validated['Type'];
            $equipment->marque = $validated['marque'];
            $equipment->etat = $validated['etat'];
            $equipment->date_amortissement = $validated['date_amortissement'];
            $equipment->status = "disponible";
            $equipment->save();

            return response()->json(['message' => 'Equipment Inserted successfully!','data' => $contract,], 200); 

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


    public function update(Request $request, $id)
    {
        try{

            // Validate the incoming request
            $validated = $request->validate([
                'num_serie' => 'required|string|',
                'contract' => 'required|string|',
                'Type' => 'required|string|',
                'marque' => 'required|string|',
                'etat'=> 'required|string|',
                'status'=> 'required|string|',
                'date_amortissement'=> 'required|date',
            ]);

            $equipment = Equipment::find($id);

            if (!$equipment) {
                return response()->json([
                    'message' => 'equipment not found.',
                ], 404);
            }
            $contract = Contract::where('ref', $validated['contract'])->first();
            if (!$contract) {
                return response()->json(['message' => 'Structure not found!'], 200);
            }

            $equipment->id_contract	 = $contract->id_contract;
            // Update the contract
            $equipment->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'equipment updated successfully.',
                'equipment' => $equipment,
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
        $equipment = Equipment::findOrFail($id);

        // Delete the contract
        $equipment->delete();

        // Return a response, could be a success message or just a status code
        return response()->json([
            'message' => 'Contract deleted successfully!'
        ]);
    }
}
