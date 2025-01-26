<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function __construct()
    {
        // Protect all methods in this controller except 'index' and 'show' (if they are public and don't require authentication)
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    
    public function index()
    {

        return auth()->user()->notifications; // Fetch all notifications for the user
    }

    public function destroy($id)
    {
        // Find the notification in the notifications table
        $notification = auth()->user()->notifications()->find($id);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        // Mark the notification as read and delete it
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully'], 200);
    }
}
