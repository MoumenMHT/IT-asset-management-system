<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;


class ActivityControler extends Controller
{
    public function getActivity(){

        try {
            // Get activities for today
            $activities = Activity::whereDate('created_at', today())->get();
        
            // Extract unique causer IDs
            $causerIds = $activities->pluck('causer_id')->unique()->filter(); // Remove null values
        
            // Fetch users in one query and map them by ID
            $users = User::whereIn('id_user', $causerIds)->pluck('username', 'id_user');
        
            // Map activities with usernames
            $lastLoggedActivity = $activities->map(function ($activity) use ($users) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'subject' => $activity->subject_type,
                    'user' => $users[$activity->causer_id] ?? 'Unknown', // Fetch username or set 'Unknown'
                    'time' => $activity->created_at->format('Y-m-d H:i:s'),
                ];
            });
        
            // Check if activities exist
            if ($lastLoggedActivity->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'No log activity found'], 404);
            }
        
            return response()->json($lastLoggedActivity, 200);
        
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
        

    }
}
