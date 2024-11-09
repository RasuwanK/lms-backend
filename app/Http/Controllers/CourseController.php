<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourseById($id): \Illuminate\Http\JsonResponse
    {
        $course = Course::findOrFail($id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        return response()->json($course, 200);
    }

}
