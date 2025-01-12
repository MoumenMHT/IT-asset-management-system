<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use App\Models\Structure;
Use App\Models\Employer;

class EmployerController extends Controller
{

    public function __construct()
    {
        // Protect all methods in this controller except 'index' and 'show' (if they are public and don't require authentication)
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getEmployer()
    {
        try {
            

            $employer = Employer::with('structure','user')->get();

            // Format the response
            $formattedemployer = $employer->map(function ($employer) {
                return [
                    'id' => $employer->id_employer,
                    'nom' => $employer->nom,
                    'prenom' => $employer->prenom,
                    'fonc' => $employer->fonc,
                    'code' => $employer->code,
                    'structure' => $employer->structure->nom ?? null,
                    'user' => $employer->user->username ?? 'null', 
                ];
            });
       
            if ($formattedemployer) {
                return response()->json( $formattedemployer , 200); // Return employer with a success message
            } else {
                return response()->json(['status' => 'error', 'message' => 'No employer found'], 404); // Return a not found response
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
            'nom' => 'required|string|',
            'prenom' => 'required|string|',
            'structure' => 'required|string|',
            'fonc' => 'required|string|',
            'code'=> 'required|string|',
        ]);
        try {
            
            $structure = Structure::where('nom', $validated['structure'])->first();
            if (!$structure) {
                return response()->json(['message' => 'Structure not found!'], 404);
            }
            
            $employer = new Employer;
            $employer->nom = $validated['nom'];
            $employer->prenom = $validated['prenom'];
            $employer->id_structure	 = $structure->id_structure; // Assign the structure ID
            $employer->fonc = $validated['fonc'];
            $employer->code = $validated['code'];
            $employer->save();

            return response()->json(['message' => 'Employer Inserted successfully!','data' => $employer,], 200); 

        }catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 404);
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
                'prenom' => 'required|string|',
                'structure' => 'required|string|',
                'fonc' => 'required|string|',
                'code'=> 'required|string|',
            ]);

            $employer = Employer::find($id);

            if (!$employer) {
                return response()->json([
                    'message' => 'employer not found.',
                ], 404);
            }
            $structure = Structure::where('nom', $validated['structure'])->first();
            if (!$structure) {
                return response()->json(['message' => 'Structure not found!'], 200);
            }
            

            $employer->id_structure	 = $structure->id_structure;
            // Update the employer
            $employer->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'employer updated successfully.',
                'employer' => $employer,
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
        $employer = Employer::findOrFail($id);

        // Delete the employer
        $employer->delete();

        // Return a response, could be a success message or just a status code
        return response()->json([
            'message' => 'employer deleted successfully!'
        ]);
    }
}
