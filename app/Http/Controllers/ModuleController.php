<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Module;
use App\Models\PortalUser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ModuleController extends Controller
{


    public function showAllModules(Request $request)
    {
        try {
            $modules = Module::all(); // Fetch all users

            // Use the ResponseHelper to return a success response
            return ResponseHelper::success('Modules retrieved successfully', $modules);
        } catch (Exception $e) {
            // Catch any general exceptions and use ResponseHelper for error response
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getModuleById(Request $request, $id)
    {
        try {
            $module = Module::find($id); // Fetch all users
            if (!$module) {
                // Return a not found error if the module doesn't exist
                return ResponseHelper::notFound('Module not found');
            }
            // Use the ResponseHelper to return a success response
            return ResponseHelper::success('Modules retrieved successfully', $module);
        } catch (Exception $e) {
            // Catch any general exceptions and use ResponseHelper for error response
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function addModule(Request $request)
    {
        try {
            $validated = $request->validate([
                'module_name' => 'required|string|max:255',
                'credit_value' => 'nullable|integer',
                'practical_exam_count' => 'nullable|integer',
                'writing_exam_count' => 'nullable|integer',
                'course_id' => 'required|exists:courses,id',
            ]);
            $module = Module::create($validated);
            return ResponseHelper::success('Module created successfully', $module);
        } catch (QueryException $qe) {
            return ResponseHelper::serverError($qe->getMessage());
        } catch (Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function updateModuleById(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'module_name' => 'sometimes|string|max:255',
                'credit_value' => 'sometimes|nullable|integer',
                'practical_exam_count' => 'sometimes|nullable|integer',
                'writing_exam_count' => 'sometimes|nullable|integer',
                'course_id' => 'sometimes|exists:courses,id',
            ]);

            $module = Module::findOrFail($id);
            $module->update($validated);

            return ResponseHelper::success('Module updated successfully', $module);
        } catch (QueryException $qe) {
            return ResponseHelper::serverError($qe->getMessage());
        } catch (ModelNotFoundException $mnfe) {
            return ResponseHelper::notFound('Module not found');
        } catch (Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }


    public function deleteModuleById($id, Request $request)
    {
        if (!$request->isMethod('delete')) {
            return ResponseHelper::methodInvalid();
        }
        try {
            Module::where('id', $id)->delete();
            return ResponseHelper::success('Module with id ' . $id . ' deleted successfully.');
        } catch (QueryException $qe) {
            return ResponseHelper::serverError($qe->getMessage());
        }
    }

    public function getAllAssignments($id)
    {
        $assignments = Activity::where('module_id', $id)
            ->where('type', 'assignment')
            ->get();
        return response()->json($assignments);
    }

    public function getAllQuizes($id)
    {
        $assignments = Activity::where('module_id', $id)
            ->where('type', 'quiz')
            ->get();
        return response()->json($assignments);
    }

    public function getAllActivitiesForAModule($id)
    {
        $module = Module::with('activities')->findOrFail($id); // Fetch module and its activities
        return response()->json($module->activities);
    }

    public function getActivity($id, $activity_id)
    {
        $module = Module::find($id); // Fetch module and its activities
        $activity = $module->activities->findOrFail($activity_id);
        return response()->json($activity);
    }

    public function deleteActivity($id, $activity_id)
    {
        $module = Module::find($id); // Fetch module and its activities
        $activity = $module->activities->findOrFail($activity_id);
        $activity->delete();
        return response()->json($activity);
    }

    public function updateActivity(Request $request, $id, $activity_id)
    {
        $module = Module::find($id); // Fetch module and its activities
        $activity = $module->activities->findOrFail($activity_id);
        $activity->update($request->all());
        return response()->json($activity);
    }

    public function addAssignment(Request $request, $id)
    {
        $module = Module::with('courses')->findOrFail($id);

        $activity = $module->activities()->create([
            'activity_name' => $request->activity_name,
            'type' => 'assignment',
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'instructions' => $request->instructions,
        ]);

        $event = $activity->events()->create([
            'event_name' => $activity->activity_name,
            'start_date' => $activity->start_date,
            'start_time' => $activity->start_time,
            'end_date' => $activity->end_date,
            'end_time' => $activity->end_time,
            'description' => $activity->description,
            'status' => 'scheduled',
        ]);
        $userids = $module->courses->flatMap(function ($course) {
            return $course->users->pluck('id');
        })->unique();

        $event->users()->attach($userids);
        return response()->json(['activity' => $activity, 'event' => $event], 201);
    }

    public function addQuiz(Request $request, $id)
    {
        $module = Module::with('courses')->findOrFail($id);

        $activity = $module->activities()->create([
            'activity_name' => $request->activity_name,
            'type' => 'quiz',
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'question_count' => $request->question_count,
        ]);
        $event = $activity->events()->create([
            'event_name' => $activity->activity_name,
            'start_date' => $activity->start_date,
            'start_time' => $activity->start_time,
            'end_date' => $activity->end_date,
            'end_time' => $activity->end_time,
            'description' => $activity->description,
            'status' => 'scheduled',
        ]);
        $userids = $module->courses->flatMap(function ($course) {  //assign all users who are enrolled in this module
            return $course->users->pluck('id');                    // no matter which course
        })->unique();

        $event->users()->attach($userids);
        return response()->json(['activity' => $activity, 'event' => $event], 201);
    }

    public function createAnnouncement(Request $request, $moduleId)
    {
        $module = Module::findOrFail($moduleId);

        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $announcement = $module->announcements()->create([
            'topic' => $request->topic,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Announcement created successfully.', 'announcement' => $announcement], 201);
    }

    public function getAnnouncements($moduleId)
    {
        $module = Module::with('announcements')->findOrFail($moduleId);

        return response()->json($module->announcements);
    }

    public function updateAnnouncement(Request $request, $announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);

        $request->validate([
            'topic' => 'string|max:255|nullable',
            'description' => 'string|nullable',
        ]);

        $announcement->update($request->only('topic', 'description'));

        return response()->json(['message' => 'Announcement updated successfully.', 'announcement' => $announcement]);
    }

    public function deleteAnnouncement($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);

        $announcement->delete();

        return response()->json(['message' => 'Announcement deleted successfully.']);
    }

}

