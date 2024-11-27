<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\PortalUser;
use App\Http\Requests\AddPortalUserRequest;
use App\Http\Requests\UpdatePortalUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Http\Request;

class PortalUserController extends Controller
{
    public function all(Request $request)
    {
        try {
            $users = PortalUser::all(); // Fetch all users

            // Use the ResponseHelper to return a success response
            return ResponseHelper::success('Users retrieved successfully', $users);
        } catch (Exception $e) {
            // Catch any general exceptions and use ResponseHelper for error response
            return ResponseHelper::serverError($e->getMessage());
        }
    }
    public function create(AddPortalUserRequest $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
    {
        // Only submission is via form
        if (!$request->accepts('multipart/form-data')) {
            return ResponseHelper::invalidMedia();
        }

        // Only allow POST requests
        if (!$request->isMethod('post')) {
            return ResponseHelper::methodInvalid();
        }
        // Must be sent via a form submission
        $full_name = $request->input('full_name');
        $age = $request->input('age');
        $email = $request->input('email');
        $mobile = $request->input('mobile_no');
        $address = $request->input('address');
        $institution = $request->input('institution');
        $password = $request->input('password');
        $role = $request->input('role');
        $status = $request->input('status');
        $course_id = $request->input('course_id');
        $profile_picture = $request->file('profile_picture');

        // Create a new user
        try {
            $user = PortalUser::create([
                'Full_Name' => $full_name,
                'Age' => $age,
                'Email' => $email,
                'Mobile_No' => $mobile,
                'Address' => $address,
                'Institution' => $institution,
                'Profile_Picture' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLe5PABjXc17cjIMOibECLM7ppDwMmiDg6Dw&s',
                'Password' => $password,
                'Role' => $role,
                'Status' => $status,
                'Course_Id' => $course_id
            ]);
            return ResponseHelper::success('User created successfully', $user);
        } catch (QueryException $qe) {
            // When a db query exception has occured
            return ResponseHelper::serverError($qe->getMessage());
        } catch (Exception $e) {
            // When a general server exception has occured
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function delete($id, Request $request)
    {
        if (!$request->isMethod('delete')) {
            return ResponseHelper::methodInvalid();
        }

        try {
            PortalUser::where('id', $id)->delete();
            return ResponseHelper::success('User with id ' . $id . ' deleted successfully.');
        } catch (QueryException $qe) {
            return ResponseHelper::serverError($qe->getMessage());
        }
    }

    public function update($id, UpdatePortalUserRequest $request)
    {
        // Only submission is via form
        if (!$request->accepts('application/json')) {
            return ResponseHelper::invalidMedia();
        }

        // Only allow POST requests
        if (!$request->isMethod('patch')) {
            return ResponseHelper::methodInvalid();
        }

        // Must be sent via a form submission
        $full_name = $request->json('full_name');
        $age = $request->json('age');
        $email = $request->json('email');
        $mobile = $request->json('mobile_no');
        $address = $request->json('address');
        $institution = $request->json('institution');
        $password = $request->json('password');
        $role = $request->json('role');
        $status = $request->json('status');
        $course_id = $request->json('course_id');
        // TODO: Need to implement profile picture
        $profile_picture = $request->file('profile_picture');

        // Create a new user
        try {
            $user = PortalUser::findOrFail($id);
            if (!$user) {
                return ResponseHelper::notFound('User not found');
            }
            if ($full_name) {
                $user->Full_name = $full_name;
            }

            if ($age) {
                $user->Age = $age;
            }

            if ($email) {
                $user->Email = $email;
            }

            if ($mobile) {
                $user->Mobile_No = $mobile;
            }

            if ($address) {
                $user->Address = $address;
            }

            if ($institution) {
                $user->Institution = $institution;
            }

            if ($password) {
                $user->Password = $password;
            }

            if ($role) {
                $user->Role = $role;
            }

            if ($status) {
                $user->Status = $status;
            }

            if ($course_id) {
                $user->Course_Id = $course_id;
            }

            $user->save();

            return ResponseHelper::success('User updated successfully', $user);
        } catch (QueryException $qe) {
            // When a db query exception has occured
            return ResponseHelper::serverError($qe->getMessage());
        } catch (Exception $e) {
            // When a general server exception has occured
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function read($id)
    {
        try {
            $user = PortalUser::find( $id);
            if(!$user) {
                return ResponseHelper::notFound('User not found');
            }
            return ResponseHelper::success('User found', $user);
        } catch (QueryException $qe) {
            return ResponseHelper::serverError($qe->getMessage());
        } catch (Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getFilteredInfo($id, $field)
    {
        try {
            // Find the user by ID
            $user = PortalUser::findOrFail($id);

            if (!isset($user->$field)) {
                return ResponseHelper::notFound('Field not found');
            }
            return ResponseHelper::success("$field retrieved successfully", [$field => $user->$field]);

        } catch (QueryException $qe ) {
            return ResponseHelper::serverError($qe->getMessage());
        } catch (Exception $e) {
            // Handle general server errors
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getUserCourses($userId)
    {
        $user = PortalUser::find($userId);
        if (!$user) {
            return ResponseHelper::notFound('User not found');
        }
        return ResponseHelper::success('User course fetched successfully', $user->course);
    }

}
