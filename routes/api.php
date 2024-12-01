<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PortalUserController;
use App\Models\PortalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::post('/generate-token/{id}', function (Request $request, $id) {
        $user = PortalUser::findOrFail($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    });
    Route::prefix('/v1/modules')->group(function () {
        Route::get('/',[ModuleController::class,'showAllModules']);
        Route::get('/{id}',[ModuleController::class,'getModuleById']);
        Route::post('/',[ModuleController::class,'addModule']);
        Route::patch('/{id}',[ModuleController::class,'updateModuleById']);
        Route::delete('/{id}',[ModuleController::class,'deleteModuleById']);
        Route::get('/{id}/activities',[ModuleController::class,'getAllActivitiesForAModule']);
        Route::get('{id}/activities/assignment',[ModuleController::class,'getAllAssignments']);
        Route::get('{id}/activities/quiz',[ModuleController::class,'getAllQuizes']);
        Route::get('/{id}/activities/{activityid}',[ModuleController::class,'getActivity']);
        Route::patch('/{id}/activities/{activityid}',[ModuleController::class,'updateActivity']);
        Route::post('/{id}/activities/assignment',[ModuleController::class,'addAssignment']);
        Route::post('/{id}/activities/quiz',[ModuleController::class,'addQuiz']);
        Route::delete('/{id}/activities/{activityid}',[ModuleController::class,'deleteActivity']);
    });

//    Route::get('/v1/modules',[ModuleController::class,'showAllModules']);
//    Route::get('/v1/modules/{id}',[ModuleController::class,'getModuleById']);
//    Route::post('/v1/modules',[ModuleController::class,'addModule']);
//    Route::patch('/v1/modules/{id}',[ModuleController::class,'updateModuleById']);
//    Route::delete('/v1/modules/{id}',[ModuleController::class,'deleteModuleById']);

    Route::get('v1/courses/{id}/modules',[CourseController::class,'listModules']);
    Route::post('v1/courses/{id}/modules',[CourseController::class,'attachModules']);
    Route::delete('v1/courses/{id}/modules',[CourseController::class,'detachModules']);


    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
    Route::post('/register',[AuthController::class,'register']);


// Routes are beginning with /v1
Route::prefix('v1')->group(function () {
    Route::get("/", function() {
        return ResponseHelper::success("Welcome to API ".config('app.version'));
    });

    // User API
    Route::prefix('users')->group(function () {

        Route::get('/test', function () {
            return ResponseHelper::success("Testing user API");
        });
        Route::get('/all',[PortalUserController::class,'all']);
        Route::post('/', [PortalUserController::class, 'create']);
        Route::patch('/{id}/', [PortalUserController::class, 'update']);
        Route::delete('/{id}/', [PortalUserController::class, 'delete']);
        Route::get('/{id}', [PortalUserController::class, 'read']);

        // Event Routes
        Route::get('/{id}/events', [EventController::class, 'getAllEvents']);
        Route::get('/{id}/events/{eventid}', [EventController::class, 'getEventInfo']);
        Route::get('/{id}/courses', [PortalUserController::class, 'getUserCourses']);
        Route::post('/{id}/events/{eventid}', [EventController::class, 'createEvent']);
        Route::patch('/{id}/events/{eventid}', [EventController::class, 'updateEvent']);
        Route::delete('/{id}/events/{eventid}', [EventController::class, 'deleteEvent']);
        Route::get('/{id}/{field}', [PortalUserController::class, 'getFilteredInfo']);
        Route::get('/{id}/courses', [PortalUserController::class, 'getUserCourses']);

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
