<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
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
    public function delete($id)
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
}
