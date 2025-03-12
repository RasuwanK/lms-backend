<?php

namespace App\Http\Controllers;

use App\Models\PortalUser;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index($user_id)
    {
        $user = PortalUser::findOrFail($user_id); // Fetch the user by ID
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $notifications = $user->unreadNotifications; // Fetch unread notifications
        return response()->json($notifications);
    }
}
