<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\AddPortalUserRequest;
use App\Models\PortalUser;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = PortalUser::where('email', $request->email)->first();

            if (!$user) {
                return ResponseHelper::unauthorized('Invalid credentials');
            }
            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseHelper::success('Login successful', ['user' => $user, 'token' => $token,]);
        } catch (Exception $e) {
            return ResponseHelper::serverError('An error occurred while logging in.', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke all tokens associated with the user
            $request->user()->tokens()->delete();

            return ResponseHelper::success('Logged out successfully.');
        } catch (Exception $e) {
            return ResponseHelper::serverError('An error occurred while logging out.', $e->getMessage());
        }
    }


    public function register(AddPortalUserRequest $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
    {
        // Only allow POST requests
        if (!$request->isMethod('post')) {
            return ResponseHelper::methodInvalid();
        }
        // Extract the validated data
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
        $profile_picture = $request->file('profile_picture'); // This will be handled by the AddPortalUserRequest validation

        try {
            // Create the user
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

            // Generate a personal access token for the user
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->courses()->attach($request->course_id);

            // Return success response
            return ResponseHelper::success('Registration successful and enrolled', [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (QueryException $qe) {
            // Handle database query exceptions
            return ResponseHelper::serverError($qe->getMessage());
        } catch (Exception $e) {
            // Handle general exceptions
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
