<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ParticipateController;
use App\Http\Controllers\PortalUserController;
use App\Http\Controllers\TopicController;
use App\Models\PortalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {

    Route::post('/generate-token/{id}', function (Request $request, $id) {
        $user = PortalUser::findOrFail($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    });

    Route::prefix('/v1/modules')->group(function () {
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
    });
    Route::patch('v1/announcements/{announcementid}', [ModuleController::class, 'updateAnnouncement']);
    Route::delete('v1/announcements/{announcementid}', [ModuleController::class, 'deleteAnnouncement']);
    Route::post('v1/announcements/{announcementid}/answers', [AnnouncementController::class, 'addAnswer']);
    Route::get('v1/announcements/{announcementid}/answers', [AnnouncementController::class, 'getAnswers']);
    Route::patch('v1/announcements/{announcementid}/answers/{answerid}', [AnnouncementController::class, 'updateAnswer'])->middleware('auth:sanctum');
    Route::delete('v1/announcements/{announcementid}/answers/{answerid}', [AnnouncementController::class, 'deleteAnswer'])->middleware('auth:sanctum');

    Route::post('v1/activities/{activityId}/submit', [ParticipateController::class, 'submitActivity']);
    Route::get('v1/activities/{activityId}/submissions', [ParticipateController::class, 'fetchSubmissions']);
    Route::patch('v1/activities/{activityId}/submissions/{userId}/grade', [ParticipateController::class, 'gradeSubmission']);

    Route::post('v1/modules/{moduleid}/topics', [ModuleController::class, 'addTopic']);
    Route::get('v1/modules/{moduleid}/topics', [ModuleController::class, 'getTopics']);
    Route::patch('v1/modules/{moduleid}/topic/{topicid}', [ModuleController::class, 'updateTopic']);
    Route::delete('v1/modules/{moduleid}/topic/{topicid}', [ModuleController::class, 'deleteTopic']);

    Route::post('v1/topics/{topicid}/materials', [ModuleController::class, 'addLectureMaterial']);
    Route::get('v1/topics/{topicid}/materials', [ModuleController::class, 'getLectureMaterials']);
    Route::patch('v1/topics/{topicid}/materials/{materialsid}', [TopicController::class, 'updateMaterials']);
    Route::delete('v1/topics/{topicid}/materials/{materialsid}', [TopicController::class, 'deleteMaterials']);
    Route::patch('v1/topics/{topicid}/toggle-visibility', [TopicController::class, 'toggleVisibility']);
    Route::patch('v1/topics/{topicid}/mark-complete', [TopicController::class, 'markAsComplete']);



    Route::post('/v1/quiz/{id}/questions', [ActivityController::class, 'addQuestion']);
    Route::get('/v1/quiz/{id}/questions', [ActivityController::class, 'getQuestions']);
    Route::patch('/v1/quiz/{id}/questions/{queid}', [ActivityController::class, 'updateQuestion']);
    Route::delete('/v1/quiz/{id}/questions/{queid}', [ActivityController::class, 'deleteSpecificQuestion']);
    Route::delete('/v1/quiz/{id}/questions', [ActivityController::class, 'deleteAllQuestion']);

    Route::get('/v1/users/{id}/events', [EventController::class, 'getAllEventsForAUser']);
    Route::get('/v1/events/{eventid}', [EventController::class, 'getSpecificEventDetails']);
    Route::post('/v1/events', [EventController::class, 'createEventForUsers']); //userids will be passed in body
    Route::get('/v1/users/{id}/events/{eventid}', [EventController::class, 'getSpecificEventForAUser']);
    Route::patch('/v1/events/{eventid}', [EventController::class, 'updateEvent']);
    Route::delete('/v1/events/{eventid}', [EventController::class, 'deleteEvent']);

    //    Route::get('/v1/modules',[ModuleController::class,'showAllModules']);
    //    Route::get('/v1/modules/{id}',[ModuleController::class,'getModuleById']);
    //    Route::post('/v1/modules',[ModuleController::class,'addModule']);
    //    Route::patch('/v1/modules/{id}',[ModuleController::class,'updateModuleById']);
    //    Route::delete('/v1/modules/{id}',[ModuleController::class,'deleteModuleById']);

    Route::get('v1/courses/{id}/modules', [CourseController::class, 'listModules']);
    Route::post('v1/courses/{id}/modules', [CourseController::class, 'attachModules']);
    Route::delete('v1/courses/{id}/modules', [CourseController::class, 'detachModules']);

    Route::prefix('v1')->group(function () {
        Route::post('/signin', [AuthController::class, 'signin']);
        Route::post('/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
        Route::post('/signup', [AuthController::class, 'signup']);
    });

    // Routes are beginning with /v1
    Route::prefix('v1')->group(function () {
        Route::get("/", function () {
            return ResponseHelper::success("Welcome to API " . config('app.version'));
        });

        // User API
        Route::prefix('users')->group(function () {

            Route::get('/test', function () {
                return ResponseHelper::success("Testing user API");
            });
            Route::get('/all', [PortalUserController::class, 'all']);
            Route::post('/', [PortalUserController::class, 'create']);
            Route::patch('/{id}/', [PortalUserController::class, 'update']);
            Route::delete('/{id}/', [PortalUserController::class, 'delete']);
            Route::get('/{id}', [PortalUserController::class, 'read']);

            // Event Routes
            Route::get('/{id}/courses', [PortalUserController::class, 'getUserCourses']);
            Route::get('/{id}/{field}', [PortalUserController::class, 'getFilteredInfo']);
            Route::get('/{id}/courses', [PortalUserController::class, 'getUserCourses']);

            Route::fallback(function () {
                return ResponseHelper::notFound("Invalid user operation");
            });
        });

        // Course API
        Route::prefix('courses')->group(function () {
            Route::get('/{id}', [CourseController::class, 'getCourseById']);
            Route::fallback(function () {
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
});
