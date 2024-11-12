<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

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

// User API
Route::prefix('users')->group(function () {
    //Route::middleware('auth:sanctum')->group(function () {
    Route::put('/{id}', [UserController::class, 'updateUser']);
    Route::delete('/{id}', [UserController::class, 'deleteUser']);
    Route::get('/{id}', [UserController::class, 'getUserInfo']);
    Route::post('/{id}', [UserController::class, 'createUser']);

    // Event Routes
    Route::get('/{id}/events', [EventController::class, 'getAllEvents']);
    Route::get('/{id}/events/{eventid}', [EventController::class, 'getEventInfo']);

    Route::post('/{id}/events/{eventid}', [EventController::class, 'createEvent']);
    Route::put('/{id}/events/{eventid}', [EventController::class, 'updateEvent']);
    Route::delete('/{id}/events/{eventid}', [EventController::class, 'deleteEvent']);
    Route::get('/{id}/{field}', [UserController::class, 'getFilteredInfo']);

    //new routes
    Route::get('/{id}/courses',[UserController::class, 'getUserCourses']);
});

// Course API
Route::prefix('courses')->group(function () {
    Route::get('/{id}', [CourseController::class, 'getCourseById']);
});

