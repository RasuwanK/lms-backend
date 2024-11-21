<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortalUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/generate-token/{id}', function (Request $request, $id) {
    // Retrieve the user by ID
    $user = User::findOrFail($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Create the token
    $token = $user->createToken('Personal Access Token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});

// Routes are begginign with /vi
Route::prefix('v1')->group(function () {
    Route::get("/", function() {
        return ResponseHelper::success("Welcome to API ".config('app.version'));
    });

    Route::get("/test", function() {
        return ResponseHelper::success("Welcome to API ".config('app.version'));
    });

    // User API
    Route::prefix('users')->group(function () {
        //Route::middleware('auth:sanctuallfunction () {
        //Route::get('/', [UserController::class, 'all']); 
        Route::get('/test', function () {
            return ResponseHelper::success("Testing user API");
        });
        Route::post('/', [PortalUserController::class, 'create']);
        Route::patch('/{id}/', [PortalUserController::class, 'update']);
        Route::delete('/{id}/', [PortalUserController::class, 'delete']);
        Route::get('/{id}', [PortalUserController::class, 'getUserInfo']);
        //Route::post('/{id}', [UserController::class, 'create']);

        // Event Routes
        Route::get('/{id}/events', [EventController::class, 'getAllEvents']);
        Route::get('/{id}/events/{eventid}', [EventController::class, 'getEventInfo']);

        Route::post('/{id}/events/{eventid}', [EventController::class, 'createEvent']);
        Route::put('/{id}/events/{eventid}', [EventController::class, 'updateEvent']);
        Route::delete('/{id}/events/{eventid}', [EventController::class, 'deleteEvent']);
        Route::get('/{id}/{field}', [UserController::class, 'getFilteredInfo']);

        //new routes
        Route::get('/{id}/courses', [UserController::class, 'getUserCourses']);

        Route::fallback(function () {
            return ResponseHelper::notFound("Invalid user operation"); 
        });
    });

    // Course API
    Route::prefix('courses')->group(function () {
        Route::get('/{id}', [CourseController::class, 'getCourseById']);
        Route::fallback(function() {
            return "Invalid course operation";
        });
    });

    Route::fallback(function () {
        return ResponseHelper::notFound("Invalid api operation");
    });
});

// Route does not available in the entire api /api/
Route::fallback(function () {
   return ResponseHelper::notFound("Invalid api version"); 
});