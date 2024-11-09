<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        // Validate incoming request
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|min:8',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->errors()], 422);
//        }

        // Create a new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function updateUser(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function getUserInfo($id): \Illuminate\Http\JsonResponse
    {
       $user = User::findOrFail($id);
       //dd($user->password);
       return response()->json($user);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }

    public function getFilteredInfo($id,$field): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        if (!isset($user->$field)) {
            return response()->json(['message' => 'Field not found']);
        }
        return response()->json([$field => $user->$field]);
    }

    public function getUserCourses($userId): \Illuminate\Http\JsonResponse
    {
        $user = User::with('courses')->find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user->courses, 200);
    }
}
