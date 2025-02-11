<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Carbon\Carbon;


class ProviderController extends Controller
{

    public function __construct()
    {
        
        // Protect all methods in this controller except 'index' and 'show' (if they are public and don't require authentication)
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    

    public function getProviders()
    {


        try {

         

            $providers = Provider::get();
            
            // Debug: Log the raw data before processing
            
            $providers = $providers->map(function ($provider) {
                return [
                    'id' => $provider->id_fournisseur,
                    'nom' => $provider->nom,
                    'created_at' => Carbon::parse($provider->created_at)->format('Y-m-d H:i:s'), 

                ];
            });
            
            if ($providers->isNotEmpty()) {
                return response()->json($providers, 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'No providers found'], 404);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fournisseur' => 'required|string|',

        ]);
        try {
            $provider = new Provider;
            $provider->nom = $validated['fournisseur'];
            $provider->save();
            return response()->json(['message' => 'Provider Inserted successfully!',
            'data' =>
                [
                    'id' => $provider->id_fournisseur,
                    'nom' => $provider->nom,
                    'created_at' => Carbon::parse($provider->created_at)->format('Y-m-d H:i:s'),
                ]
            ], 200); 

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

            $provider = Provider::find($id);

            if (!$provider) {
                return response()->json([
                    'message' => 'Contract not found.',
                ], 404);
            }
            

            $provider->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'Contract updated successfully.',
                'contract' => $provider,
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
        $fournisseur = Provider::findOrFail($id);

        // Delete the contract
        $fournisseur->delete();

        // Return a response, could be a success message or just a status code
        return response()->json([
            'message' => 'fournisseur deleted successfully!'
        ]);
    }
}
