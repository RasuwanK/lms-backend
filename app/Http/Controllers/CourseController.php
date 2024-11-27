<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourseById($id): \Illuminate\Http\JsonResponse
    {
        $course = Course::find($id);

        if (!$course) {
            return ResponseHelper::notFound('Course not found');
        }

        return ResponseHelper::success('Course fetched successfully', $course);
    }


}
