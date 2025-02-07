<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Employer;
Use App\Models\Equipment;
Use App\Models\Hostory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;





class HistoryController extends Controller
{
   

    public function __construct()
    {
        // Protect all methods in this controller except 'index' and 'show' (if they are public and don't require authentication)
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }


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
                    'status' => $history->status,
                    'path' => $history->path,
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
                if($validated['type']=== 'assignment'){
                    $equipement->status = "indisponible";
                    $equipement->etat = "used";
                    $equipement->id_employer = $employer->id_employer;



                }else{
                    $equipement->status = "disponible";
                    $equipement->id_employer = null;

                }
                $equipement->update();
    
            } else {
                // Find available equipment
                $equipement = Equipment::where('id_equipement', $validated['equipement']['id_equipement'])
                                       ->where('status', 'disponible')
                                       ->first();
                
                if (!$equipement) {
                    return response()->json(['message' => 'Equipment not found or not available'], 200);
                }
    
                $history->type = 'assignment';
                $equipement->etat = "used";
                $history->id_equipement = $equipement->id_equipement;
                $equipement->id_employer = $employer->id_employer;
    
                // Update equipment status to "indisponible"
                $equipement->status = "indisponible";
                $equipement->update();
            }
            $history->status = "en attente";
    
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
      
        $request->validate([
            'file' => 'required|string', // Validate Base64 string
        ]);

    
        try{

            $history = Hostory::find($id);

            

            $history->status = "confirmer";


            $base64File = $request->input('file');

            // Decode Base64 file
            $fileData = explode(',', $base64File);
            $fileContent = base64_decode($fileData[1]);
            
            // Get file extension
            preg_match('/^data:(\w+\/\w+);base64,/', $base64File, $matches);
            $extension = explode('/', $matches[1])[1] ?? 'txt';
            
            // Generate a unique file name
            $fileName = $history->type . '_' . $history->employer->nom . '_' . $history->employer->prenom . '_' . $history->equipement->num_serie . '.' . $extension;
            
            // Save the file to the public storage directory
            $filePath = 'uploads/' . $fileName;
            Storage::disk('public')->put($filePath, $fileContent);
            
            // Store the relative URL in the database
            $history->path = $filePath; // Save only the relative path
            $history->update();
            
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file_name' => $fileName,
                'file_path' => '/storage/' . $filePath, // Return the public URL
            ]);
            
     
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
