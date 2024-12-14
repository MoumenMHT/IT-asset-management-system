<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Structure;
use App\Models\Provider;


class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app');

    }

    public function getContracts()
    {
        try {
            

            $contracts = Contract::with('structure','fournisseur')->get();

            // Format the response
            $formattedContracts = $contracts->map(function ($contract) {
                return [
                    'id' => $contract->id_contract,
                    'ref' => $contract->ref,
                    'date_acquisition' => $contract->date_acquisition,
                    'garantie' => $contract->garantie,
                    'Type_contract' => $contract->Type_contract,
                    'structure_nom' => $contract->structure->nom ?? null,
                    'fournisseur' => $contract->fournisseur->nom ?? null, 
                ];
            });
       
            if ($formattedContracts) {
                return response()->json( $formattedContracts , 200); // Return contracts with a success message
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
        $validated = $request->validate([
            'ref' => 'required|string|',
            'Type_contract' => 'required|string|',
            'structure' => 'required|string|',
            'fournisseur' => 'required|string|',
            'date_acquisition'=> 'required|date|',
            'garantie'=> 'required|date',

        ]);
        try {
            
            $structure = Structure::where('nom', $validated['structure'])->first();
            if (!$structure) {
                return response()->json(['message' => 'Structure not found!'], 200);
            }
            $fournisseur = Provider::where('nom', $validated['fournisseur'])->first();
            if (!$fournisseur) {
                return response()->json(['message' => 'fournisseur not found!'], 200);
            }
            $contract = new Contract;
            $contract->ref = $validated['ref'];
            $contract->Type_contract = $validated['Type_contract'];
            $contract->id_structure	 = $structure->id_structure; // Assign the structure ID
            $contract->id_fournisseur	 = $fournisseur->id_fournisseur; // Assign the structure ID            
            $contract->date_acquisition = $validated['date_acquisition'];
            $contract->garantie = $validated['garantie'];
            $contract->save();

            return response()->json(['message' => 'Contract Inserted successfully!','data' => $contract,], 200); 

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
                'ref' => 'required|string|',
                'Type_contract' => 'required|string|',
                'structure' => 'required|string|',
                'fournisseur' => 'required|string|',
                'date_acquisition'=> 'required|date|',
                'garantie'=> 'required|date',
            ]);

            $contract = Contract::find($id);

            if (!$contract) {
                return response()->json([
                    'message' => 'Contract not found.',
                ], 404);
            }
            $structure = Structure::where('nom', $validated['structure'])->first();
            if (!$structure) {
                return response()->json(['message' => 'Structure not found!'], 200);
            }
            $fournisseur = Provider::where('nom', $validated['fournisseur'])->first();
            if (!$fournisseur) {
                return response()->json(['message' => 'Structure not found!'], 200);
            }

            $contract->id_structure	 = $structure->id_structure;
            $contract->id_fournisseur = $fournisseur->id_fournisseur;
            // Update the contract
            $contract->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'Contract updated successfully.',
                'contract' => $contract,
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
        $contract = Contract::findOrFail($id);

        // Delete the contract
        $contract->delete();

        // Return a response, could be a success message or just a status code
        return response()->json([
            'message' => 'Contract deleted successfully!'
        ]);
    }
}
