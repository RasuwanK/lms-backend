<?php

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

//Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::get('/users/{id}', [UserController::class, 'getUserInfo']);

    // Event Routes
    Route::get('/users/{id}/events', [EventController::class, 'getAllEvents']);
    Route::get('/users/{id}/events/{eventid}', [EventController::class, 'getEventInfo']);

    Route::post('/users/{id}/events/{eventid}', [EventController::class, 'createEvent']);
    Route::put('/users/{id}/events/{eventid}', [EventController::class, 'updateEvent']);
    Route::delete('/users/{id}/events/{eventid}', [EventController::class, 'deleteEvent']);
    Route::get('/users/{id}/{field}', [UserController::class, 'getFilteredInfo']);
//});
