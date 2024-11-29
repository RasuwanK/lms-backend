<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function listModules($course_id)
    {
        $course=Course::find($course_id);
        return ResponseHelper::success($course->modules);
    }

    public function attachModules(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        $moduleIds = $request->module_ids; // Expecting an array of module IDs
        $course->modules()->attach($moduleIds);

        return ResponseHelper::success($course->modules);
    }

    public function detachModules(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        $moduleIds = $request->module_ids;
        $detachedModules = $course->modules()
            ->whereIn('modules.id', $moduleIds) // Explicitly specify the table name
            ->get();

        if ($detachedModules->isEmpty()) {
            return ResponseHelper::notFound('No matching modules found to detach');
        }
        $course->modules()->detach($moduleIds);

        return ResponseHelper::success("modules deleted successfully",$detachedModules);
    }

    public function getCourseById($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return ResponseHelper::notFound('Course not found');
        }

        return ResponseHelper::success('Course fetched successfully', $course);
    }


}
