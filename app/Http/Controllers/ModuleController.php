<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
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
            $users = Module::all(); // Fetch all users

            // Use the ResponseHelper to return a success response
            return ResponseHelper::success('Modules retrieved successfully', $users);
        } catch (Exception $e) {
            // Catch any general exceptions and use ResponseHelper for error response
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getModuleById(Request $request,$id)
    {
        try {
            $user = Module::find($id); // Fetch all users

            // Use the ResponseHelper to return a success response
            return ResponseHelper::success('Modules retrieved successfully', $user);
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
}
