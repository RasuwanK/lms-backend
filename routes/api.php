<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParticipateController;
use App\Http\Controllers\PortalUserController;
use App\Http\Controllers\TopicController;
use App\Models\PortalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

//Broadcast::channel('App.Models.PortalUser.{id}', function ($user,$id) {
//    return (int) $user->id === (int) $id;
//});
//Broadcast::channel('activities', function () {
//    return true;
//});
Route::post('/generate-token/{id}', function (Request $request, $id) {
    $user = PortalUser::findOrFail($id);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    $token = $user->createToken('Personal Access Token')->plainTextToken;
    return response()->json(['token' => $token], 200);
});

// Related to version 1.0
Route::prefix('/v1')->group(function () {

    Route::get('/notifications/{id}',[NotificationController::class, 'index']);
    // Modules related
    Route::prefix('/modules')->group(function () {
        Route::get('/', [ModuleController::class, 'showAllModules']);
        Route::get('/{id}', [ModuleController::class, 'getModuleById']);
        Route::post('/', [ModuleController::class, 'addModule']);
        Route::patch('/{id}', [ModuleController::class, 'updateModuleById']);
        Route::delete('/{id}', [ModuleController::class, 'deleteModuleById']);
        Route::get('/{id}/activities', [ModuleController::class, 'getAllActivitiesForAModule']);
        Route::get('{id}/activities/assignment', [ModuleController::class, 'getAllAssignments']);
        Route::get('{id}/activities/quiz', [ModuleController::class, 'getAllQuizes']);
        Route::get('/{id}/activities/{activityid}', [ModuleController::class, 'getActivity']);
        Route::patch('/{id}/activities/{activityid}', [ModuleController::class, 'updateActivity']);
        Route::post('/{id}/activities/assignment', [ModuleController::class, 'addAssignment']);
        Route::post('/{id}/activities/quiz', [ModuleController::class, 'addQuiz']);
        Route::delete('/{id}/activities/{activityid}', [ModuleController::class, 'deleteActivity']);
        Route::post('/{id}/announcements', [ModuleController::class, 'createAnnouncement']);
        Route::get('/{id}/announcements', [ModuleController::class, 'getAnnouncements']);
        Route::post('/{moduleid}/topics', [ModuleController::class, 'addTopic']);
        Route::get('/{moduleid}/topics', [ModuleController::class, 'getTopics']);
        Route::patch('/{moduleid}/topic/{topicid}', [ModuleController::class, 'updateTopic']);
        Route::delete('/{moduleid}/topic/{topicid}', [ModuleController::class, 'deleteTopic']);
    });

    // Announcements related
    Route::prefix('/announcements')->group(function () {
        Route::patch('/{announcementid}', [ModuleController::class, 'updateAnnouncement']);
        Route::delete('/{announcementid}', [ModuleController::class, 'deleteAnnouncement']);
        //Route::post(uri: '/{announcementid}/answers', [AnnouncementController::class, 'addAnswer']);
        Route::get('/{announcementid}/answers', [AnnouncementController::class, 'getAnswers']);
        Route::patch('/{announcementid}/answers/{answerid}', [AnnouncementController::class, 'updateAnswer'])->middleware('auth:sanctum');
        Route::delete('/{announcementid}/answers/{answerid}', [AnnouncementController::class, 'deleteAnswer'])->middleware('auth:sanctum');
    });

    // Activities related
    Route::prefix('/activities')->group(function () {
        Route::post('/{activityId}/submit', [ParticipateController::class, 'submitActivity']);
        Route::get('{activityId}/submissions', [ParticipateController::class, 'fetchSubmissions']);
        Route::patch('/{activityId}/submissions/{userId}/grade', [ParticipateController::class, 'gradeSubmission']);
    });

    // Topics related
    Route::prefix('/topics')->group(function () {
        Route::post('/{topicid}/materials', [ModuleController::class, 'addLectureMaterial']);
        Route::get('/{topicid}/materials', [ModuleController::class, 'getLectureMaterials']);
        Route::patch('/{topicid}/materials/{materialsid}', [TopicController::class, 'updateMaterials']);
        Route::delete('/{topicid}/materials/{materialsid}', [TopicController::class, 'deleteMaterials']);
        Route::patch('/{topicid}/toggle-visibility', [TopicController::class, 'toggleVisibility']);
        Route::patch('/{topicid}/mark-complete', [TopicController::class, 'markAsComplete']);
    });

    Route::prefix('/quiz')->group(function () {
        Route::post('/{id}/questions', [ActivityController::class, 'addQuestion']);
        Route::get('/{id}/questions', [ActivityController::class, 'getQuestions']);
        Route::patch('/{id}/questions/{queid}', [ActivityController::class, 'updateQuestion']);
        Route::delete('/{id}/questions/{queid}', [ActivityController::class, 'deleteSpecificQuestion']);
        Route::delete('/{id}/questions', [ActivityController::class, 'deleteAllQuestion']);
    });

    Route::prefix('/events')->group(function () {
        // TODO: Need to fix this Route::get('/v1/users/{id}/events', [EventController::class, 'getAllEventsForAUser']);
        Route::get('events/{eventid}', [EventController::class, 'getSpecificEventDetails']);
        Route::post('/', [EventController::class, 'createEventForUsers']); //userids will be passed in body
        // TODO: Need to fix this Route::get('/v1/users/{id}/events/{eventid}', [EventController::class, 'getSpecificEventForAUser']);
        Route::patch('/{eventid}', [EventController::class, 'updateEvent']);
        Route::delete('/{eventid}', [EventController::class, 'deleteEvent']);
    });

    // Handling courses
    Route::prefix('/courses')->group(function () {
        Route::get('/{id}/modules', [CourseController::class, 'listModules']);
        Route::post('/{id}/modules', [CourseController::class, 'attachModules']);
        Route::delete('/{id}/modules', [CourseController::class, 'detachModules']);
        Route::post('/', [CourseController::class, 'createCourse']);
        Route::fallback(function () {
            return "Invalid course operation";
        });
    });

    // User API
    Route::prefix('users')->group(function () {

        Route::get('/test', function () {
            return ResponseHelper::success("Testing user API");
        });
        Route::get('/', [PortalUserController::class, 'all']);
        Route::get('/students', [PortalUserController::class, 'students']);
        Route::get('/lecturers', [PortalUserController::class, 'lecturers']);
        Route::post('/', [PortalUserController::class, 'create']);
        Route::patch('/{id}/', [PortalUserController::class, 'update']);
        Route::delete('/{id}/', [PortalUserController::class, 'delete']);
        Route::get('/{id}', [PortalUserController::class, 'read']);
        Route::get('/{id}/events', [EventController::class, 'getAllEventsForAUser']);   // new event routes
        Route::get('/{id}/events/{eventid}', [EventController::class, 'getSpecificEventForAUser']);   // new event routes


        Route::prefix('/auth')->group(function () {
            Route::post('/signin', [AuthController::class, 'signin']);
            Route::post('/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
            Route::post('/signup', [AuthController::class, 'signup']);
        });
    });

    //    Route::get('/v1/modules',[ModuleController::class,'showAllModules']);
    //    Route::get('/v1/modules/{id}',[ModuleController::class,'getModuleById']);
    //    Route::post('/v1/modules',[ModuleController::class,'addModule']);
    //    Route::patch('/v1/modules/{id}',[ModuleController::class,'updateModuleById']);
    //    Route::delete('/v1/modules/{id}',[ModuleController::class,'deleteModuleById']);


    // Routes are beginning with /v1
    Route::prefix('v1')->group(function () {
        Route::get("/", function () {
            return ResponseHelper::success("Welcome to API " . config('app.version'));
        });

        // Event Routes
        Route::get('/{id}/courses', [PortalUserController::class, 'getUserCourses']);
        Route::get('/{id}/{field}', [PortalUserController::class, 'getFilteredInfo']);
        Route::get('/{id}/courses', [PortalUserController::class, 'getUserCourses']);

        Route::fallback(function () {
            return ResponseHelper::notFound("Invalid user operation");
        });
    });

    // Course API
    Route::prefix('courses')->group(function () {});

    Route::fallback(function () {
        return ResponseHelper::notFound("Invalid api operation");
    });
});

// Route does not available in the entire api /api/
Route::fallback(function () {
    return ResponseHelper::notFound("Invalid api version");
});
