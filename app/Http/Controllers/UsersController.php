<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employer;

class UsersController extends Controller
{
  



    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'store', 'checkAuth']);
    }

    public function checkAuth(Request $request)
{
    // This will return 'authenticated' as true if the user is logged in
    return response()->json([
        'authenticated' => Auth::check(),
    ], 200);
}
    


    public function getUser()
    {
        try {
            


            $employers = Employer::whereNotNull('id_user')->get();


            // Format the response
            $formattedUsers = $employers->map(function ($employer) {
                return [
                    'id' => $employer->user->id_user, 
                    'code' => $employer->code,
                    'username' => $employer->user->username,
                    'password' => $employer->user->password,
                    'type' => $employer->user->Type,

                ];
            });
       
            if ($formattedUsers) {
                return response()->json( $formattedUsers , 200); // Return users with a success message
            } else {
                return response()->json(['status' => 'error', 'message' => 'No users found'], 404); // Return a not found response
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        if($user){
            return response()->json(['user'=>$user], 200);

        }else{
            return response()->json(['message' => 'user not found'],300);
        }

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
            'username' => 'required|string|',
            'type' => 'required|String|',
            'password' => 'required|string|',
            'employer' => 'required|string|',
        ]);
        try{
            if (User::where('username', $validated['username'])->exists()) {
                return response()->json(['message' => 'Username already exists, please choose another one.'], 200);
            }
    
            $employer = Employer::where('nom', $validated['employer'])->first();
    
            if (!$employer) {
                return response()->json(['message' => 'Employer not found.'], 200);
            }
            if ($employer->id_user !== null) {
                return response()->json(['message' => 'This employer already has a user assigned.'], 200);
            }
    
    
            $user = new User;
    
            $user->username = $validated['username'];
            $user->type = $validated['type'];
            $user->password = Hash::make($validated['password']); // Hash the password
                $user->save();
    
            $employer->id_user = $user->id_user;
            $employer->save();
            return response()->json(['message' => 'User registered successfully!','debug'=> $employer], 200);

        }
        catch (\Exception $e) {
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
        $validated = $request->validate([
            'username' => 'required|string|',
            'type' => 'required|String|',
            'password' => 'required|string|',
        ]);
        try{

        
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'user not found.',
                ], 404);
            }
            if (User::where('username', $validated['username'])->exists()) {
                return response()->json(['message' => 'Username already exists, please choose another one.'], 200);
            }


            $validated['password'] = hash('md5',$validated['password']);

           
            // Update the user
            $user->update($validated);

            // Return a success response
            return response()->json([
                'message' => 'user updated successfully.',
                'user' => $user->password,
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
        try{

            $user = User::findOrFail($id);
            $employer = Employer::where('id_user',$user->id_user)->first();
            if(!$employer){
                return response()->json(['message' => 'Employer not found!']);

            }
            
            $employer->id_user = null ;
            $employer->update();

            // Delete the user
            $user->delete();

            // Return a response, could be a success message or just a status code
            return response()->json(['message' => 'user deleted successfully!']);
        }catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());
            
            // Return a generic error response
            return response()->json($e->getMessage(), 200);
        }
        
    }


    
    //Login Function
    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'username' => 'required|string', // Change to 'email' if you're using email
            'password' => 'required|string',
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Generate a token for the user using Sanctum
            $token = $user->createToken('authToken')->plainTextToken;
    
            return response()->json([
                'message' => 'Login successful.',
                'token' => $token,
                'authenticated' => true,
                'user' => $user->only(['id_user', 'username', 'Type']),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials.',
                'authenticated' => false,
            ], 401);
        }
    }
    

    
}
